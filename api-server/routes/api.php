<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
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


Route::post('/logowanie', [AuthController::class, 'login'] );


// TODO separate paths for teacher from paths for students by role which user is login with
Route::middleware('auth:sanctum')->group(function() {

    // User details
    Route::get( '/user', [ UserController::class, 'user' ] );

    // Logout
    Route::post( '/logout', [ AuthController::class, 'logout' ] );

    // Teacher Subjects
    Route::get( '/teacher/subjects', [ SubjectController::class, 'showTeacherSubject' ] );

    // Teacher Classes
    Route::get( '/teacher/subject={subject_id}/classes', [ ClassController::class, 'showTeacherClass' ] );

});
