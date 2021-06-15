<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/books','BookController@store');
Route::patch('/books/{book}','BookController@update');
Route::delete('/books/{book}','BookController@destroy');

Route::post('/authors', 'AuthorController@store');

Route::post('/checkout/{book}','CheckoutController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
