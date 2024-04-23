<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassroomController;
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

Route::resource('classrooms', ClassroomController::class);
Route::resource('students', StudentController::class);
Route::resource('teachers', TeacherController::class);
Route::controller(TeacherController::class)->group(function () {
    Route::post('teachers/add-to-classroom', 'addTeacherToClassroom');
    Route::post('teachers/remove-from-classroom', 'removeTeacherFromClassroom');
});


