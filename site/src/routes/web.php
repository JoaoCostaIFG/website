<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::feeds();

Route::view('/login', 'pages.home')->name('login');
Route::view('/logout', 'pages.home')->name('logout');

Route::view('/blog', 'pages.blog.index')->name('blogs');
Route::get('/blog/{id}', [BlogController::class, 'show'])->where('id', '[0-9]+')->name('blog');
Route::view('/blog/new', 'pages.blog.index')->name('blog_new');
Route::view('/blog/{id}/edit', 'pages.blog.index')->where('id', '[0-9]+')->name('blog_edit');

Route::view('/projects', 'pages.home')->name('projects');
Route::view('/projects/new', 'pages.home')->name('project_new');
Route::view('/projects/{id}/edit', 'pages.home')->where('id', '[0-9]+')->name('project_edit');

Route::view('/workshops', 'pages.home')->name('workshops');
Route::view('/workshops/{name}', 'pages.home')->where('name', '[0-9a-zA-Z]+')->name('workshop');
