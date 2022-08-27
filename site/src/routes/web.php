<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProjController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::feeds();

Route::view('/login', 'pages.login')->name('login');
Route::post('/login', [usercontroller::class, 'authenticate'])->name('login_action');
Route::get('/logout', [usercontroller::class, 'logout'])->name('logout');

Route::view('/blog', 'pages.blog.index')->name('blogs');
Route::get('/blog/{id}', [BlogController::class, 'show'])->where('id', '[0-9]+')->name('blog');
Route::view('/blog/new', 'pages.blog.new')->middleware('auth')->name('blog_new');
Route::post('/blog/new', [BlogController::class, 'new'])->middleware('auth')->name('blog_new_action');
Route::get('/blog/{id}/edit', [BlogController::class, 'editForm'])->where('id', '[0-9]+')->middleware('auth')->name('blog_edit');
Route::post('/blog/edit', [BlogController::class, 'edit'])->middleware('auth')->name('blog_edit_action');

Route::view('/projects', 'pages.proj.index')->name('projects');
Route::view('/projects/new', 'pages.proj.new')->middleware('auth')->name('project_new');
Route::post('/projects/new', [ProjController::class, 'new'])->middleware('auth')->name('project_new_action');
Route::get('/projects/{id}/edit', [ProjController::class, 'editForm'])->where('id', '[0-9]+')->middleware('auth')->name('project_edit');
Route::post('/projects/edit', [ProjController::class, 'edit'])->middleware('auth')->name('project_edit_action');

Route::view('/workshops', 'pages.home')->name('workshops');
Route::view('/workshops/{name}', 'pages.home')->where('name', '[0-9a-zA-Z]+')->name('workshop');
