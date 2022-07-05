<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\EmployeeController;
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
    Route::prefix('package')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('package');
        Route::post('/store', [PackageController::class, 'store'])->name('package.store');
        Route::post('/update/{id}', [PackageController::class, 'update'])->name('package.update');
        Route::get('/destroy/{id}', [PackageController::class, 'destroy'])->name('package.destroy');
    });
    Route::prefix('item')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('item');
        Route::post('/store', [ItemController::class, 'store'])->name('item.store');
        Route::post('/update/{id}', [ItemController::class, 'update'])->name('item.update');
        Route::get('/destroy/{id}', [ItemController::class, 'destroy'])->name('item.destroy');
    });
    Route::get('/income', [IncomeController::class, 'index'])->name('income');
    Route::get('/expense', [ExpenseController::class, 'index'])->name('expense');
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
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
