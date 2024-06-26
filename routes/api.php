<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;

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

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::controller(TeacherController::class)->group(function () {
        Route::post('classroom-management/teachers', 'addTeacherToClassroom');
        Route::post('classroom-management/teachers/{id}', 'removeTeacherFromClassroom');
    });
    Route::resource('subjects', SubjectController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
});
