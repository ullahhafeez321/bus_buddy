<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BusLocationController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// // });

Route::post('/login', [LoginController::class, 'login']);
Route::post('/update-location', [BusLocationController::class, 'store']);
Route::get('/driver-location', [BusLocationController::class, 'getLatestLocation']);
// Route::middleware('auth:sanctum')->group(function () {

// });



