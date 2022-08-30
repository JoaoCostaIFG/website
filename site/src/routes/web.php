<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\IdenticonsController;
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
Route::get('/blog/{id}', [BlogController::class, 'show'])->whereNumber('id')->name('blog');
Route::get('/blog/{id}/{title}', [BlogController::class, 'showPretty'])->whereNumber('id')->name('blog_pretty');
Route::view('/blog/new', 'pages.blog.new')->middleware('auth')->name('blog_new');
Route::post('/blog/new', [BlogController::class, 'new'])->middleware('auth')->name('blog_new_action');
Route::get('/blog/{id}/edit', [BlogController::class, 'editForm'])->whereNumber('id')->middleware('auth')->name('blog_edit');
Route::post('/blog/edit', [BlogController::class, 'edit'])->middleware('auth')->name('blog_edit_action');

Route::get('/identicons/{input}/{quality?}', [IdenticonsController::class, 'show'])->whereNumber('quality')->name('identicons');

Route::view('/projects', 'pages.proj.index')->name('projects');
Route::view('/projects/new', 'pages.proj.new')->middleware('auth')->name('project_new');
Route::post('/projects/new', [ProjController::class, 'new'])->middleware('auth')->name('project_new_action');
Route::get('/projects/{id}/edit', [ProjController::class, 'editForm'])->whereNumber('id')->middleware('auth')->name('project_edit');
Route::post('/projects/edit', [ProjController::class, 'edit'])->middleware('auth')->name('project_edit_action');

Route::view('/workshops', 'pages.workshop.index')->name('workshops');
Route::get('/workshops/{name}', function (Request $request, string $name) {
  return view('pages.workshop.workshop', ['name' => $name]);
})->whereAlphaNumeric('name')->name('workshop');
