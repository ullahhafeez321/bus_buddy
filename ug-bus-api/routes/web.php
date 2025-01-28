<?php

use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\LoginController;
use App\Http\Controllers\UnverifiedWordController;
use App\Http\Controllers\VerifiedWordController;
use App\Http\Controllers\DefinitionController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\LoginController;
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

// Route::get('/',function () {
//     return redirect('/login');
// });


// Route::post('login', [LoginController::class, 'login']);
// Route::middleware('auth:sanctum')->get('/dashboard', function (Request $request) {
//     return response()->json($request->user());
// });

Auth::routes();

Route::middleware(['auth'])->group(function () {

    # Dashboard words 
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:driver,student');
    // Route::post('/dashboard/store', [DashboardController::class, 'store']);

    # users 
    Route::get('/users',[UsersController::class,'index'])->middleware('role:admin');
    Route::post('/users/update',[UsersController::class,'update'])->name('update_user')->middleware('role:admin');
    Route::post('/users/delete',[UsersController::class,'destroy'])->name('delete_user')->middleware('role:admin');

});