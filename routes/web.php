<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessengerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
//     Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
//     Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
//     Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');
//     Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
//     Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');


//     Route::controller(AdminController::class)->group(function() {
//         Route::get('/all/type', 'AllType')->name('all.type');
//         Route::get('/add/type', 'AddType')->name('add.type');
//     });

// });

// Route::middleware(['auth', 'role:agent'])->group(function () {
//     Route::get('/agent/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');
// });


Route::group(['middleware'=> 'auth'], function () {
    Route::get('/messenger', [MessengerController::class, 'index'])->name('home');
    Route::post('/profile-update', [UserController::class, 'updateProfile'])->name('profile.update');

    //search route
    Route::get('/messenger/search', [MessengerController::class, 'searchUser'])->name('messenger.search');
});



