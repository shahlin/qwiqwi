<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeTrackingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/list', [TimeTrackingController::class, 'list']);
Route::get('/track-time', [TimeTrackingController::class, 'trackTime']);