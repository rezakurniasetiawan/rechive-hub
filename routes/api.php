<?php

use App\Http\Controllers\API\Finance\ApiFinanceTransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Raw;

// API Routes
Route::controller(ApiFinanceTransactionController::class)->group(function () {
    Route::get('/finance/types', 'getFinanceTypes')->name('api.finance.types');
    Route::get('/finance/accounts', 'getFinanceAccounts')->name('api.finance.accounts');
    Route::get('/finance/categories', 'getFinanceCategories')->name('api.finance.categories');
});
