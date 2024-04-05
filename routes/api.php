<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\ClassRoomTeacherController;
use App\Http\Controllers\Teacher\TeacherController;
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
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::delete('/{user}', [UserController::class, 'delete']);
        Route::put('/{user}', [UserController::class, 'update']);
    });

    Route::group(['prefix' => 'student'], function () {
        Route::get('/', [StudentController::class, 'index']);
    });
    Route::group(['prefix' => 'teacher'], function () {
        Route::get('/', [TeacherController::class, 'index']);
    });
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'index']);
    });
});


Route::group(['prefix' => 'teacher', 'middleware' => ['auth:sanctum', 'role:teacher']], function () {
    Route::group(['prefix' => 'class'], function () {
        Route::get('/', [ClassRoomTeacherController::class, 'index']);
        Route::post('/', [ClassRoomTeacherController::class, 'store']);
        Route::delete('/{classRoom}', [ClassRoomTeacherController::class, 'delete']);
        Route::put('/{classRoom}', [ClassRoomTeacherController::class, 'update']);
        Route::put('/{classRoom}/new-unique-code', [ClassRoomTeacherController::class, 'updateCode']);
    });
});
