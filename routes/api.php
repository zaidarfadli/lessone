<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::group(['prefix' => 'student'], function () {
//     Route::group(['prefix' => 'class'], function () {
//     });
//     Route::group(['middleware' => ['auth:sanctum', 'role:student']], function () {
//         Route::get('');
//     });
// });
// Route::group(['prefix' => 'student'], function () {
//     Route::group(['prefix' => 'class'], function () {
//     });
//     Route::group(['middleware' => ['auth:sanctum', 'role:student']], function () {
//         Route::get('');
//     });
// });



Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// INI bisa diakses jika user sudah login saja,dan rolenya admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'role:admin']], function () {
    // ROUTE AUTH
    Route::group(['prefix' => 'student'], function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::post('/', [StudentController::class, 'store']);
        Route::get('/{user}', [StudentController::class, 'show']);
        Route::delete('/{user}', [StudentController::class, 'delete']);
        Route::put('/{user}', [StudentController::class, 'update']);
    });


    Route::post('/logout', [AuthController::class, 'logout']);
});
