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

Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/workshops', 'pages.home')->name('workshops');
Route::feeds();

Route::view('/login', 'pages.home')->name('login');
Route::view('/logout', 'pages.home')->name('logout');

Route::view('/blog', 'pages.blog.index')->name('blog_index');
Route::view('/blog/{id}', 'pages.home')->where('id', '[0-9]+')->name('blog_post');

Route::view('/projects', 'pages.home')->name('projects');
