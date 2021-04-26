<?php

namespace App\Http\Controllers;

use App\ApiModels\Base\ApiResponse;
use App\ApiModels\Data\ApiCode;
use App\Models\StudentActivity;
use App\Services\ClassService;
use App\Services\StudentService;
use App\Services\SubjectService;
use App\WebModels\StudentActivityWebModel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $classService;
    private $subjectService;
    private $studentService;

    public function __construct(ClassService $classService,
                                SubjectService $subjectService,
                                StudentService $studentService)
    {
        $this->classService = $classService;
        $this->subjectService = $subjectService;
        $this->studentService = $studentService;
    }


    // Save student activity data to student_activity table
    public function storeStudentActivity (Request $request, $subjectName, $date) {

        // Create object for keep request data
        $studentActivity = new StudentActivityWebModel;


        // Initialize data from request
        $studentActivity->setStudentIdentifier($request->all());
        $studentActivity->setSubjectName($subjectName);
        $studentActivity->setDateActive($date);


        // Load all students together with first student from request by his identifier
        $studentIdsList = $this->classService->getStudentsIdFromClass($request[0]);


        // Get ids of becoming students from request
        $idsOfActiveStudents = $this->classService->getIdsOfActiveStudents($studentActivity->getStudentIdentifier());


        // Get id of subject which for active students are saving
        $subjectId = $this->subjectService->getSubjectId($studentActivity->getSubjectName())[0];


        // Go through all students from current class
        foreach ( $studentIdsList as $studentId ) {

            // Set default value
            $isActive = 0;

            // Stupid double loop
            foreach( $idsOfActiveStudents as $activeStudentId ) {
                foreach( $activeStudentId as $actStu ){
                    if ( $actStu == $studentId ) {
                        $isActive = 1;
                    }
                }
            }

            // Collect all data for saving
            $studentActivityToSave = new StudentActivity( [
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'active' => $isActive,
                'date_active' => $studentActivity -> getDateActive()
            ] );

            // Save active of current student on loop
            $this -> studentService -> storeStudentActivity( $studentActivityToSave );

        }


        return ApiResponse::withSuccess(ApiCode::STORE_STUDENT_ACTIVE);
    }


    /**
     * @param $class string The class contains identifier number and number
     */
    public function showStudentsOfClass ( string $class ) {

        // Split class request param by character index
        $classNumber = $class[0];
        $identifierClassNumber = $class[1];

        $result = $this->classService->getStudentListByClass($classNumber, $identifierClassNumber);

        // return student list
        return ApiResponse::withSuccess($result);
    }
}
