<?php

namespace App\Http\Controllers;

use App\ApiModels\Base\ApiResponse;
use App\ApiModels\Data\ApiCode;
use App\ApiModels\Marks\Design\MarkItem;
use App\ApiModels\Marks\MarksItemViewResultApiModel;
use App\ApiModels\Marks\MarksListViewResultApiModel;
use App\ApiModels\StudentResultApiModel;
use App\Models\StudentActivity;
use App\Services\ClassService;
use App\Services\HarmonogramService;
use App\Services\StudentService;
use App\Services\SubjectService;
use App\WebModels\Marks\MarkInsert;
use App\WebModels\Marks\MarkListEdit;
use App\WebModels\Marks\MarkListInsert;
use App\WebModels\Marks\MarkRevision;
use App\WebModels\StudentActivityWebModel;
use Facade\FlareClient\Api;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $classService;
    private $subjectService;
    private $studentService;
    private $harmonogramService;

    public function __construct( ClassService $classService,
                                 SubjectService $subjectService,
                                 StudentService $studentService,
                                 HarmonogramService $dateService)
    {
        $this->classService = $classService;
        $this->subjectService = $subjectService;
        $this->studentService = $studentService;
        $this->harmonogramService = $dateService;
    }


    // Save student activity data to student_activity table
    public function storeStudentActivity (Request $request, $subjectName, $date) {

        // Create object for keep request data
        $studentActivity = new StudentActivityWebModel;


        // Initialize data from request
        $studentActivity->setStudentIdentifier($request->all());
        $studentActivity->setSubjectName($subjectName);
        $studentActivity->setDateActive($date);


        // TODO: Get students by class id
        // Load all students together with first student from request by his identifier
        $studentIdsList = $this->classService->getStudentsIdFromClass($request[0]);


        // Get ids of becoming students from request
        $idsOfActiveStudents = $this->classService->getIdsOfActiveStudents($studentActivity->getStudentIdentifier());


        // Get id of subject which for active students are saving
        $subjectId = $this->subjectService->getSubjectId($studentActivity->getSubjectName())[0];


        // Get id of class by first identifier from request
        $classId = $this->classService->getClassIdByIdentifier($request[0])[0];


        // Get time from harmonogram to set start time lesson for active list
        $timeActive = $this->harmonogramService->setTimeActive( $subjectId, $classId );
        if ($timeActive == 0)
            return ApiResponse::badRequest(ApiCode::NOTSTORE_STUDENT_ACTIVE);


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
                'date_active' => $studentActivity -> getDateActive(),
                'time_active' => $timeActive
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

    public function showStudentMarksOfClassForSubject($subject, $class) {

        // Collect all students with their marks
        $studentsWithMarks = new MarksListViewResultApiModel();


        // Get data from db by request
        $studentList = $this->classService->getStudentListByClass($class[0], $class[1]);


        // For each student with marks
        foreach ( $studentList as $st ) {

            // Create next Student
            $student = new StudentResultApiModel();

            // Create next single student with his marks
            $studentWithMarks = new MarksItemViewResultApiModel();

            // Initialize student with details
            $student->setFirstName($st['first_name']);
            $student->setLastName($st['last_name']);
            $student->setIdentifier($st['identifier']);

            // Get marks by current student identifier and subject
            $markListItem = $this->studentService->getStudentMarksBySubject($student->getIdentifier(), $subject);


            // Initialize student with marks
            $studentWithMarks->setStudent($student);
            $studentWithMarks->setMarks($markListItem);

            // Append next student with his marks to array of all students
            $studentsWithMarks -> setStudentMark($studentWithMarks);
        }


        return ApiResponse::withSuccess( $studentsWithMarks->getStudentMark() );
    }

    public function editStudentMarks( Request $request ) {

        // Initialize mark list with data
        $marksListToEdit = new MarkListEdit();
        $marksListToEdit->setMarkList($request->all());

        // For each item of list
        foreach ( $marksListToEdit->getMarkList() as $item ) {

            // Initialize single mark of item list
            $markItem = new MarkItem();
            $markItem->setMark($item['mark']);
            $markItem->setStudentMarksId($item['student_marks_id']);

            $this->studentService->modifyStudentMarks($markItem);
        }

        return ApiResponse::withSuccess(null, ApiCode::MARKS_UPDATE_SUCCESS);
    }

    public function insertStudentMark(Request $request) {

        #region Web Models Declare

        $markRevision = new MarkRevision;
        $markListInsert = new MarkListInsert;

        #endregion

        #region Web Models Initialize

        $markRevision->setSubject($request['name']);
        $markRevision->setDate($request['date']);
        $markRevision->setTopic($request['revision']['topic']);
        $markRevision->setKindOf($request['revision']['kindOf']);

        $markListInsert->setMarkRevision($markRevision);

        #endregion

        // Get all marks from request ...
        $marks = $request->all()['marks'];

        // ... for iterate through each
        foreach ( $marks as $mark ) {
            $markInsert = new MarkInsert;
            $markInsert->setIdentifier($mark['identifier']);
            $markInsert->setMark($mark['mark']);

            // Append current mark to list of marks
            $markListInsert->setMarks($markInsert);
        }

        $this->studentService->storeStudentMarks($markListInsert);

        return ApiResponse::withSuccess(null, ApiCode::MARKS_INSERT_SUCCESS);
    }
}
