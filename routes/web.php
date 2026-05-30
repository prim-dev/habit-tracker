<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitLogController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Home Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});
/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Habits
    |--------------------------------------------------------------------------
    */

    Route::get('/habits', [HabitController::class, 'index'])
        ->name('habits');

    Route::post('/habits', [HabitController::class, 'store']);

    Route::post('/habits/{habit}/complete', [HabitLogController::class, 'store'])
        ->name('habits.complete');

    Route::delete('/habits/{habit}', [HabitController::class, 'destroy'])
        ->name('habits.destroy');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [UserController::class, 'profile'])
        ->name('profile');

    Route::post('/profile/update', [UserController::class, 'updateProfile'])
        ->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Users CRUD
    |--------------------------------------------------------------------------
    */

    Route::get('/users', [UserController::class, 'index'])
        ->name('users');

    Route::post('/users', [UserController::class, 'store']);

    Route::post('/users/update/{id}', [UserController::class, 'update'])
        ->name('users.update');

    Route::post('/users/delete/{id}', [UserController::class, 'delete'])
        ->name('users.delete');

});