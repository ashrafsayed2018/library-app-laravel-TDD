<?php

use Illuminate\Support\Facades\Route;

Route::post('/books','BookController@store');
Route::patch('/books/{book}','BookController@update');
Route::delete('/books/{book}','BookController@destroy');

Route::post('/authors', 'AuthorController@store');
