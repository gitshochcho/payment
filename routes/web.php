<?php

use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [StripeController::class, 'index'])->name('home');
Route::get('/subscription', [StripeController::class, 'stripeSubscripbe'])->name('subcribe');
Route::get('/cancel-subcribtion/{subId}', [StripeController::class, 'cancelStripeSubscripbe'])->name('cancel-subcribtion');
Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');
Route::get('/success', [StripeController::class, 'success'])->name('success-url');
Route::get('/fail', [StripeController::class, 'fail'])->name('fail-url');
