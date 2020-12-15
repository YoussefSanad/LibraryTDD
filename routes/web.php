<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/books', '\App\Http\Controllers\BookController@store');
Route::patch('/books/{book}', '\App\Http\Controllers\BookController@update');
Route::delete('/books/{book}', '\App\Http\Controllers\BookController@destroy');

Route::post('/authors', '\App\Http\Controllers\AuthorController@store');
Route::patch('/authors/{author}', '\App\Http\Controllers\AuthorController@update');
Route::delete('/authors/{author}', '\App\Http\Controllers\AuthorController@destroy');
