<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('invoices')->group(function () {
    Route::post('', [InvoiceController::class, 'store']);
    Route::get('{invoice}', [InvoiceController::class, 'show']);
    Route::get('{invoice}/download', [InvoiceController::class, 'invoicePdfDownload']);
});
