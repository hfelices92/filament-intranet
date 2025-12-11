<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/personal');
});


Route::get('/pruebas/{user}', [PdfController::class , 'TimeSheetRecords'])->name('pdf.example');
