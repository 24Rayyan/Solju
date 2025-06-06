<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\keuanganController;

Route::resource('orders', OrderController::class);
Route::get('orders/{order}/download-invoice', [OrderController::class, 'downloadInvoice'])->name('orders.downloadInvoice');
Route::get('/orders/{id}/upload-bukti', [OrderController::class, 'showUploadForm'])->name('orders.upload.form');
Route::post('/orders/{id}/upload-bukti', [OrderController::class, 'storeUpload'])->name('orders.upload.store');
Route::get('/orders/{order}/payment', [OrderController::class, 'payment'])->name('orders.payment');
Route::get('/orders/upload/{order}', [OrderController::class, 'showUpload'])->name('orders.upload.show');
Route::get('/orders/{order}/bukti', [OrderController::class, 'showBukti'])->name('orders.bukti');
Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard.index');
Route::resource('produk', OrderProductController::class);
Route::get('/keuangan', [KeuanganController::class, 'search'])->name('keuangan.index');
Route::get('/keuangan/search', [KeuanganController::class, 'search'])->name('keuangan.search');




