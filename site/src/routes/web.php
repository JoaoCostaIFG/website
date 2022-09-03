<?php

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

Route::prefix('blog')->group(function () {
  Route::view('/', 'pages.blog.index')->name('blogs');
  Route::middleware('auth')->group(function () {
    Route::get('/new', [BlogController::class, 'new'])->name('blog_new');
    Route::post('/edit', [BlogController::class, 'edit'])->name('blog_edit_action');
    Route::get('/{b}/edit', [BlogController::class, 'editForm'])->whereNumber('b')->name('blog_edit');
  });
  Route::get('/{b}', [BlogController::class, 'show'])->whereNumber('b')->name('blog');
  Route::get('/{b}/{title}', [BlogController::class, 'showPretty'])->whereNumber('b')->name('blog_pretty');
});

Route::get('/identicons/{input}/{quality?}', [IdenticonsController::class, 'show'])->whereNumber('quality')->name('identicons');

Route::prefix('projects')->group(function () {
  Route::view('/', 'pages.proj.index')->name('projects');
  Route::middleware('auth')->group(function () {
    Route::view('/new', 'pages.proj.new')->name('project_new');
    Route::post('/new', [ProjController::class, 'new'])->name('project_new_action');
    Route::get('/{p}/edit', [ProjController::class, 'editForm'])->whereNumber('p')->name('project_edit');
    Route::post('/edit', [ProjController::class, 'edit'])->name('project_edit_action');
  });
});

Route::view('/workshops', 'pages.workshop.index')->name('workshops');
Route::get('/workshops/{name}', function (string $name) {
  return view('pages.workshop.workshop', ['name' => $name]);
})->whereAlphaNumeric('name')->name('workshop');
