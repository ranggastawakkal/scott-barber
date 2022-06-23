<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('app.auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route::middleware(['auth:admin'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('app.admin.dashboard');
//     });
// });

// Route::middleware(['auth:employee'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('app.employee.dashboard');
//     });
// });

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

require __DIR__ . '/auth.php';
