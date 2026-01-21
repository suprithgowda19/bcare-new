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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = User::role('staff')
            ->with(['category', 'wards'])
            ->latest()
            ->get();

        return view('admin.master.staff.index', compact('staffs'));
    }

    public function create()
    {
        return view('admin.master.staff.create', [
            'categories'    => Category::where('status', 'active')->select('id', 'name')->get(),
            'corporations'  => Corporation::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /* ================= AJAX CASCADES ================= */

    public function getSubCategories(Request $request)
    {
        $request->validate(['category_id' => 'required|exists:categories,id']);
        return SubCategory::where('category_id', $request->category_id)
            ->select('id', 'name')->orderBy('name')->get();
    }

    public function getZones(Request $request)
    {
        $request->validate(['corporation_id' => 'required|exists:corporations,id']);
        return Zone::where('corporation_id', $request->corporation_id)
            ->select('id', 'name')->orderBy('name')->get();
    }

    public function getConstituencies(Request $request)
    {
        $request->validate(['zone_id' => 'required|exists:zones,id']);
        return Constituency::where('zone_id', $request->zone_id)
            ->select('id', 'name')->orderBy('name')->get();
    }

    public function getWards(Request $request)
    {
        $request->validate(['constituency_id' => 'required|exists:constituencies,id']);
        return Ward::where('constituency_id', $request->constituency_id)
            ->select('id', 'number', 'name')->orderBy('number')->get();
    }

    /* ================= STORE ================= */

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'phone'           => 'required|digits:10|unique:users,phone',
            'password'        => 'required|min:8',
            'category_id'     => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'wards'           => 'required|array|min:1',
            'wards.*'         => 'exists:wards,id',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'            => $request->name,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'password'        => Hash::make($request->password),
                'category_id'     => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'status'          => 'active',
            ]);

            $user->assignRole('staff');
            $user->wards()->sync($request->wards);
        });

        return redirect()->route('admin.master.staff.index')->with('success', 'Staff created successfully');
    }
    public function show(User $staff)
    {
        // Eager load relations to avoid N+1
        $staff->load([
            'category',
            'subCategory',
            'wards'
        ]);

        return view('admin.master.staff.show', compact('staff'));
    }


    /* ================= EDIT ================= */

    public function edit(User $staff)
    {
        // 1. Load the categories and corporations (same as Create)
        $categories = Category::where('status', 'active')->select('id', 'name')->get();
        $corporations = Corporation::select('id', 'name')->orderBy('name')->get();

        // 2. Fetch the specific data for THIS staff member's current location
        // This prevents the "Undefined Variable" error
        $zones = Zone::where('corporation_id', $staff->corporation_id)
            ->select('id', 'name')->get();

        $constituencies = Constituency::where('zone_id', $staff->zone_id)
            ->select('id', 'name')->get();

        $availableWards = Ward::where('constituency_id', $staff->constituency_id)
            ->select('id', 'number', 'name')->get();

        // 3. Get the subcategories for the staff's chosen category
        $subCategories = SubCategory::where('category_id', $staff->category_id)
            ->select('id', 'name')->get();

        // 4. Get the IDs of wards currently assigned (for the multi-select)
        $assignedWards = $staff->wards->pluck('id')->toArray();

        return view('admin.master.staff.edit', compact(
            'staff',
            'categories',
            'subCategories',
            'corporations',
            'zones',
            'constituencies',
            'availableWards',
            'assignedWards'
        ));
    }

    /* ================= UPDATE ================= */

    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $staff->id,
            'phone'           => 'required|digits:10|unique:users,phone,' . $staff->id,
            'password'        => 'nullable|min:8', // Optional on update
            'category_id'     => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'wards'           => 'required|array|min:1',
            'wards.*'         => 'exists:wards,id',
        ]);

        DB::transaction(function () use ($request, $staff) {
            $updateData = [
                'name'            => $request->name,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'category_id'     => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $staff->update($updateData);

            // Sync handles adding new, removing old, and keeping existing assignments
            $staff->wards()->sync($request->wards);
        });

        return redirect()->route('admin.master.staff.index')->with('success', 'Staff updated successfully');
    }

    /* ================= DESTROY ================= */

    public function destroy($id)
    {
        $staff = User::findOrFail($id);

        DB::transaction(function () use ($staff) {
            // Detach many-to-many relationships before deleting the user
            $staff->wards()->detach();
            $staff->delete();
        });

        return redirect()->route('admin.master.staff.index')->with('success', 'Staff deleted successfully');
    }
}
