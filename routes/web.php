<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

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
    Route::prefix('daily-transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('daily-transactions');
        Route::post('/storeIncome', [TransactionController::class, 'storeIncome'])->name('transactions.income.store');
        Route::post('/storeExpense', [TransactionController::class, 'storeExpense'])->name('transactions.expense.store');
        Route::get('/get-package-price/{id}', [TransactionController::class, 'getPackagePrice'])->name('transactions.get-package-price');
        Route::post('/update/{id}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::get('/destroy/{id}', [TransactionController::class, 'destroy'])->name('daily-transactions.destroy');
    });
});

Route::middleware(['auth','RoleCheck:admin'])->group(function () {
    Route::prefix('journal')->group(function(){
        Route::get('/cash-flow', [JournalController::class, 'cashFlow'])->name('cash-flow');
        Route::get('/income-statement', [JournalController::class, 'incomeStatement'])->name('income-statement');
        Route::get('/get-total-value/{minDate}/{maxDate}', [JournalController::class, 'getTotalValue'])->name('journal.get-total-value');
        Route::get('/get-income-statement-value/{minDate}/{maxDate}', [JournalController::class, 'getIncomeStatementValue'])->name('journal.get-income-statement-value');
    });
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
    Route::prefix('employee')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::get('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    });
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

require __DIR__ . '/auth.php';
