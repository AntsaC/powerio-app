<?php

use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::prefix('quotations')->name('quotations.')->group(function () {
    Route::get('{quotation}/pdf/download', [QuotationController::class, 'downloadPDF'])->name('pdf.download');
    Route::get('{quotation}/pdf/stream', [QuotationController::class, 'streamPDF'])->name('pdf.stream');
});
