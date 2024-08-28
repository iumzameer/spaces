<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\User\UserAuth;
use App\Livewire\User\Dashboard;

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
    Route::get('/login', UserAuth::class);
    Route::get('/dashboard', Dashboard::class);
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
