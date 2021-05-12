<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Routes\ApiRoutes;
use App\Routes\WebRoutes;
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


Route::post(ApiRoutes::LOGIN, [AuthController::class, 'login'] );


// TODO separate paths for teacher from paths for students by role which user is login with
Route::middleware('auth:sanctum')->group(function() {

    #region API

    // Teacher Subjects
    Route::get( ApiRoutes::TEACHER_SUBJECT, [ SubjectController::class, 'showTeacherSubject' ] );

    // Teacher Classes by Subject
    Route::get( ApiRoutes::TEACHER_CLASS_OF_SUBJECT, [ ClassController::class, 'showTeacherClassBySubject' ] );

    // Student list for class
    Route::get( ApiRoutes::STUDENTS_OF_CLASS, [ StudentController::class, 'showStudentsOfClass' ] );

    // Student marks of specific class
    Route::get(ApiRoutes::MARKS_LIST_CLASS, [ StudentController::class, 'showStudentMarksOfClassForSubject' ] );

    #endregion

    #region WEB

    // Logout
    Route::post( WebRoutes::LOGOUT, [ AuthController::class, 'logout' ] );

    // Student activity
    Route::put( WebRoutes::STUDENT_ACTIVE, [ StudentController::class, 'storeStudentActivity' ] );

    // Edit marks by teacher
    Route::put( WebRoutes::TEACHER_MARKS_EDIT, [StudentController::class, 'editStudentMarks'] );

    // Insert marks by teacher
    Route::post( WebRoutes::TEACHER_MARKS_INSERT, [StudentController::class, 'insertStudentMark'] );

    #endregion

});
