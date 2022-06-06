<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilesController;
use App\Http\Middleware\CheckJson;

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


Route::post('/add_file', [FilesController::class, 'addFile'])->middleware(CheckJson::class);
Route::post('/delete_file', [FilesController::class, 'deleteFile'])->middleware(CheckJson::class);
Route::post('/search_file', [FilesController::class, 'searchFile'])->middleware(CheckJson::class);

