<?php

use App\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('api-user');

    Route::post('/blog/img', [BlogController::class, 'imgUpload'])->name('api-img');
    Route::get('/blog/imgs/{id}', [BlogController::class, 'imgList'])->whereNumber('id')->name('api-img_list');
    Route::delete('/blog/img/{id}/{name}', [BlogController::class, 'imgDelete'])->whereNumber('id')->name('api-img_delete');
});
