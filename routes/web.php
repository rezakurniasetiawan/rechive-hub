<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Finance\{
    FinanceAccountController,
    FinanceCategoryController,
    FinanceTransactionController,
    FundTransferController
};
use App\Http\Controllers\User\UserController;

// Auth Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/login', 'actionlogin')->name('auth.actionlogin');
    // auth.actionloginpin
    Route::post('/login/pin', 'actionloginpin')->name('auth.actionloginpin');
    Route::post('/logout', 'actionlogout')->name('auth.actionlogout');
});

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(FinanceTransactionController::class)->group(function () {
        Route::get('/transactions', 'transaction')->name('transactions');
        Route::post('/transactions/store', 'transactionStore')->name('transactions.store');
    });
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    // Finance Routes
    Route::prefix('finance')->name('finance.')->group(function () {
        // Account Routes
        Route::prefix('account')->name('account.')->controller(FinanceAccountController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/update/{id}', 'update')->name('update');
            Route::post('/edit/{id}', 'edit')->name('edit');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });
        // Category Routes
        Route::prefix('category')->name('category.')->controller(FinanceCategoryController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/update/{id}', 'update')->name('update');
            Route::post('/edit/{id}', 'edit')->name('edit');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });
        // Transaction Routes
        Route::prefix('transaction')->name('transaction.')->controller(FinanceTransactionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/update/{id}', 'update')->name('update');
            Route::post('/edit/{id}', 'edit')->name('edit');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });
        // Fund Transfer Routes
        Route::prefix('fundtransfer')->name('fundtransfer.')->controller(FundTransferController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
        });
    });


    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create');
        Route::post('/users/store', 'store')->name('users.store');
        Route::get('/users/update/{id}', 'edit')->name('users.edit');
        Route::post('/users/edit/{id}', 'update')->name('users.update');
    });
});
