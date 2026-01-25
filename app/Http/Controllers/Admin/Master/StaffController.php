<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Corporation;
use App\Models\Zone;
use App\Models\Constituency;
use App\Models\Ward;
use App\Models\Designation;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 1. LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $staffs = User::role('staff')
            ->with([
                'designation.category',
                'designation.subCategory',
                'wards'
            ])
            ->latest()
            ->get();

        return view('admin.master.staff.index', compact('staffs'));
    }

    /*
    |--------------------------------------------------------------------------
    | 2. CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.master.staff.create', [
            'categories'   => Category::where('status', 'active')->orderBy('name')->get(),
            'corporations' => Corporation::orderBy('name')->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | 3. STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'phone'          => 'required|digits:10|unique:users,phone',
            'password'       => 'required|min:8',
            'designation_id' => 'required|exists:designations,id',
            'wards'          => 'required|array|min:1',
            'wards.*'        => 'exists:wards,id',
        ]);

        try {

            DB::transaction(function () use ($request) {

                $user = User::create([
                    'name'           => $request->name,
                    'email'          => $request->email,
                    'phone'          => $request->phone,
                    'password'       => Hash::make($request->password),
                    'designation_id' => $request->designation_id,
                    'status'         => 'active',
                ]);

                $user->assignRole('staff');

                $user->wards()->sync($request->wards);
            });

            return redirect()
                ->route('admin.master.staff.index')
                ->with('success', 'Staff onboarded successfully.');

        } catch (\Throwable $e) {

            return back()
                ->with('error', 'Failed to onboard staff.')
                ->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 4. SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $staff = User::role('staff')
            ->with([
                'designation.category',
                'designation.subCategory',
                'wards.constituency.zone.corporation'
            ])
            ->findOrFail($id);

        return view('admin.master.staff.show', compact('staff'));
    }

    /*
    |--------------------------------------------------------------------------
    | 5. EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $staff = User::role('staff')
            ->with('wards')
            ->findOrFail($id);

        return view('admin.master.staff.edit', [
            'staff'         => $staff,
            'categories'    => Category::where('status', 'active')->get(),
            'corporations'  => Corporation::all(),
            'selectedWards' => $staff->wards->pluck('id')->toArray(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | 6. UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $staff = User::role('staff')->findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $staff->id,
            'phone'          => 'required|digits:10|unique:users,phone,' . $staff->id,
            'designation_id' => 'required|exists:designations,id',
            'wards'          => 'required|array|min:1',
            'wards.*'        => 'exists:wards,id',
        ]);

        try {

            DB::transaction(function () use ($request, $staff) {

                $data = $request->only([
                    'name',
                    'email',
                    'phone',
                    'designation_id'
                ]);

                if ($request->filled('password')) {
                    $data['password'] = Hash::make($request->password);
                }

                $staff->update($data);

                $staff->wards()->sync($request->wards);
            });

            return redirect()
                ->route('admin.master.staff.index')
                ->with('success', 'Staff updated successfully.');

        } catch (\Throwable $e) {

            return back()
                ->with('error', 'Update failed.')
                ->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 7. DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $staff = User::role('staff')->findOrFail($id);

        // Prevent deletion if active complaints exist
        if (
            Complaint::where('assigned_to_user_id', $staff->id)
                ->whereNotIn('status', ['resolved'])
                ->exists()
        ) {
            return back()->with('error', 'Cannot delete staff with active complaints.');
        }

        DB::transaction(function () use ($staff) {
            $staff->wards()->detach();
            $staff->delete();
        });

        return redirect()
            ->route('admin.master.staff.index')
            ->with('success', 'Staff removed successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX FILTER ENDPOINTS
    |--------------------------------------------------------------------------
    */

    public function getSubCategories(Request $request)
    {
        return response()->json(
            SubCategory::where('category_id', $request->category_id)
                ->where('status', 'active')
                ->select('id', 'name')
                ->orderBy('name')
                ->get()
        );
    }

    public function getEligibleDesignations(Request $request)
    {
        if (!$request->category_id) {
            return response()->json([]);
        }

        $query = Designation::where('category_id', $request->category_id);

        if ($request->filled('sub_category_id')) {
            $query->where(function ($q) use ($request) {
                $q->where('subcategory_id', $request->sub_category_id)
                  ->orWhereNull('subcategory_id');
            });
        } else {
            $query->whereNull('subcategory_id');
        }

        return response()->json(
            $query->select('id', 'name')
                  ->orderBy('name')
                  ->get()
        );
    }

    public function getZones(Request $request)
    {
        return response()->json(
            Zone::where('corporation_id', $request->corporation_id)
                ->select('id', 'name')
                ->orderBy('name')
                ->get()
        );
    }

    public function getConstituencies(Request $request)
    {
        return response()->json(
            Constituency::where('zone_id', $request->zone_id)
                ->select('id', 'name')
                ->orderBy('name')
                ->get()
        );
    }

    public function getWards(Request $request)
    {
        return response()->json(
            Ward::where('constituency_id', $request->constituency_id)
                ->select('id', 'number', 'name')
                ->orderBy('number')
                ->get()
        );
    }
}
