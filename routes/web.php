<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/* --- Main Controllers --- */
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\UpdateController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SchemeController;

/* --- Master Data Controllers --- */
use App\Http\Controllers\Admin\Master\CategoryController;
use App\Http\Controllers\Admin\Master\SubCategoryController;
use App\Http\Controllers\Admin\Master\StaffController;

/* --- Auth Controllers (Aliased to avoid conflicts) --- */
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Staff\Auth\LoginController as StaffLoginController;
use App\Http\Controllers\Public\Auth\LoginController as PublicLoginController;
use App\Http\Controllers\Public\Auth\RegisterController;

/* --- Logic Controllers --- */
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ComplaintController;
use App\Http\Controllers\Staff\ComplaintUpdateController;

/*
|--------------------------------------------------------------------------
| Public Landing & Default Auth
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('complaints.index'); // public index/dashboard
    }

    return redirect()->route('public.login');
});

Auth::routes(['login' => false]); // Disable default login to use our custom ones below

/*
|--------------------------------------------------------------------------
| Admin Panel & Auth
|--------------------------------------------------------------------------
*/
// Admin Login Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// Admin Protected Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('banners', BannerController::class);
    Route::resource('news', NewsController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('updates', UpdateController::class);
    Route::resource('about', AboutController::class);
    Route::resource('content', ContentController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('schemes', SchemeController::class);

    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('category', CategoryController::class);
        Route::resource('sub-category', SubCategoryController::class);
        Route::resource('staff', StaffController::class);

        Route::get('get-sub-categories', [StaffController::class, 'getSubCategories'])->name('get-sub-categories');
        Route::get('get-zones', [StaffController::class, 'getZones'])->name('get-zones');
        Route::get('get-constituencies', [StaffController::class, 'getConstituencies'])->name('get-constituencies');
        Route::get('get-wards', [StaffController::class, 'getWards'])->name('get-wards');
    });
});

/*
|--------------------------------------------------------------------------
| Staff Portal & Auth
|--------------------------------------------------------------------------
*/
Route::prefix('staff')->name('staff.')->group(function () {

    // Staff Authentication
    Route::get('/login', [StaffLoginController::class, 'showLoginForm'])
        ->name('auth.login');

    Route::post('/login', [StaffLoginController::class, 'login'])
        ->name('login.submit');

    Route::post('/logout', [StaffLoginController::class, 'logout'])
        ->name('logout');

    // Protected Staff Area
    Route::middleware(['auth', 'role:staff'])->group(function () {

        // Dashboard (Active / Assigned Complaints)
        Route::get('/dashboard', [ComplaintUpdateController::class, 'index'])
            ->name('dashboard');

        // Complaints
        Route::prefix('complaints')->name('complaints.')->group(function () {

            // ✅ Solved / Resolved Complaints (NEW)
            Route::get('/solved', [ComplaintUpdateController::class, 'solvedComplaints'])
                ->name('solved');

            // Complaint Details
            Route::get('/{complaint}', [ComplaintUpdateController::class, 'show'])
                ->name('show');

            // Edit Classification / Priority
            Route::get('/{complaint}/edit', [ComplaintUpdateController::class, 'edit'])
                ->name('edit');

            // Update Classification / Priority
            Route::put('/{complaint}', [ComplaintUpdateController::class, 'update'])
                ->name('update');

            // Status Update with Remarks / Images
            Route::post('/{complaint}/status', [ComplaintUpdateController::class, 'updateStatus'])
                ->name('status');
        });
    });
});


/*
|--------------------------------------------------------------------------
| Public Citizen Portal & Auth
|--------------------------------------------------------------------------
*/
Route::get('/home', [HomeController::class, 'index'])->name('public.home');

Route::prefix('public')->group(function () {
    Route::get('/register', [RegisterController::class, 'show'])->name('public.register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [PublicLoginController::class, 'show'])->name('public.login');
    Route::post('/login', [PublicLoginController::class, 'authenticate'])->name('login.auth');
    Route::post('/logout', [PublicLoginController::class, 'logout'])->name('public.logout');
});

Route::middleware(['auth', 'role:public'])->prefix('complaints')->name('complaints.')->group(function () {
    Route::get('/', [ComplaintController::class, 'index'])->name('index');
    Route::get('/category', [ComplaintController::class, 'category'])->name('category');
    Route::get('/sub_category', [ComplaintController::class, 'sub_category'])->name('sub_category');
    Route::get('/new', [ComplaintController::class, 'create'])->name('create');
    Route::post('/store', [ComplaintController::class, 'store'])->name('store');
    Route::get('/report', [ComplaintController::class, 'report'])->name('report');
    
    // FIXED: Removed the extra 'complaints.' from name because it's already in the group name
    Route::get('/view/{complaint}', [ComplaintController::class, 'show'])->name('show');
});