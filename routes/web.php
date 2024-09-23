<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\user\UserAuth;
use App\Livewire\user\Dashboard;
use App\Livewire\user\Wizard;
use App\Livewire\user\Reservations;
use App\Livewire\user\Profile;

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

Route::prefix('user')->group(function () {
    Route::get('/login', UserAuth::class)->name('user.login');
    Route::get('/dashboard', Dashboard::class)->name('user.dashboard');
    Route::get('/wizard', Wizard::class)->name('user.wizard');
    Route::get('/reservations', Reservations::class)->name('user.reservations');
    Route::get('/account', Profile::class)->name('user.profile');
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
         return "admin";});
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
