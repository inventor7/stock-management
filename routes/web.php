<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

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

// pdf generator with laravel invoices
Route::get('/{record}/pdf/download', [InvoiceController::class, 'download'])->name('order.pdf.download');
Route::get('/{record}/pdf', [InvoiceController::class, 'viewPdf'])->name('order.pdf');
