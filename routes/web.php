<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\user\UserAuth;
use App\Livewire\user\Dashboard;
use App\Livewire\user\Wizard;
use App\Livewire\user\Reservations;
use App\Livewire\user\Profile;

use App\Livewire\admin\Dashboard as AdminDashboard;

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
    return redirect()->route('admin.dashboard');
});

Route::get('/user/login', UserAuth::class)->name('user.login');

Route::prefix('user')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('user.dashboard');
    Route::get('/wizard', Wizard::class)->name('user.wizard');
    Route::get('/reservations', Reservations::class)->name('user.reservations');
    Route::get('/account', Profile::class)->name('user.profile');
    Route::get('/logout', UserAuth::class)->name('user.logout');
});

Route::prefix('admin')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
});


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
