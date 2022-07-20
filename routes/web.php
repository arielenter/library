<?php

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CheckinBookController;
use App\Http\Controllers\CheckoutBookController;
use Illuminate\Support\Facades\Route;

Route::post('books', [BooksController::class, 'store']);
Route::patch('books/{book}', [BooksController::class, 'update']);
Route::delete('books/{book}', [BooksController::class, 'destroy']);

Route::post('authors', [AuthorsController::class, 'store']);

Route::post('checkout/{book}', [CheckoutBookController::class, 'store']);
Route::post('checkin/{book}', [CheckinBookController::class, 'store']);

Route::get('login', function(){ echo 'hello'; })->name('login');