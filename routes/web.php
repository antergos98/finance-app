<?php

use App\Http\Controllers\EntriesController;
use App\Http\Controllers\ShowDashboardController;
use App\Http\Controllers\UploadEntriesController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', ShowDashboardController::class)->middleware(['auth']);
Route::view('/dashboard-old', 'layouts.app-old')->middleware(['auth']);

Route::get('/entries/upload', [UploadEntriesController::class, 'index']);
Route::post('/entries/upload', [UploadEntriesController::class, 'store']);

Route::resource('entries', EntriesController::class)->only(['create', 'store', 'update', 'destroy']);

require __DIR__.'/auth.php';
