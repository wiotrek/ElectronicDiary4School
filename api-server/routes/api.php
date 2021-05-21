<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
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
    Route::get( ApiRoutes::STUDENTS_OF_CLASS, [ StudentController::class, 'showStudentFrequenty' ] );

    // Student marks of specific class
    Route::get(ApiRoutes::MARKS_LIST_CLASS, [ StudentController::class, 'showStudentMarksOfClassForSubject' ] );

    // Subjects list of the specific student
    Route::get(ApiRoutes::STUDENT_SUBJECTS, [StudentController::class, 'studentSubjects']);

    // For each student subject listed marks
    Route::get(ApiRoutes::MARKS_OF_EACH_SUBJECT, [StudentController::class, 'showMarksOfEachSubject']);

    // For each student subject listed frequency days
    Route::get(ApiRoutes::FREQUENCY_OF_EACH_SUBJECT, [StudentController::class, 'showFrequencyOfEachSubject']);

    // Student average marks of all subject marks average
    Route::get(ApiRoutes::TOTAL_AVERAGE_MARKS, [StudentController::class, 'showAverageMarks']);

    // Student average frequency of all subject frequency average
    Route::get(ApiRoutes::TOTAL_AVERAGE_FREQUENCY, [StudentController::class, 'showAverageFrequency']);

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
