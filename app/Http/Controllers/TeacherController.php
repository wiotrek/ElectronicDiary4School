<?php

namespace App\Http\Controllers;

use App\ApiModels\Base\ApiResponse;
use App\ApiModels\Data\ApiCode;
use App\ApiModels\Frequency\StudentFrequencyListResultApiModel;
use App\ApiModels\Frequency\StudentFrequencyResultApiModel;
use App\ApiModels\Marks\Design\MarkItem;
use App\ApiModels\Marks\MarksItemViewResultApiModel;
use App\ApiModels\Marks\MarksListViewResultApiModel;
use App\ApiModels\StudentResultApiModel;
use App\Helpers\RoleDetecter;
use App\Services\ClassService;
use App\Services\HarmonogramService;
use App\Services\StudentService;
use App\Services\SubjectService;
use App\Services\TeacherService;
use App\WebModels\Marks\MarkInsert;
use App\WebModels\Marks\MarkListEdit;
use App\WebModels\Marks\MarkListInsert;
use App\WebModels\Marks\MarkRevision;
use App\WebModels\StudentFrequencyWebModel;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private $subjectService;
    private $classService;
    private $harmonogramService;
    private $studentService;
    private $teacherService;

    public function __construct( SubjectService $subjectService,
                                                       ClassService $classService,
                                                       HarmonogramService $harmonogramService,
                                                       StudentService $studentService,
                                                       TeacherService $teacherService)
    {
        $this->subjectService = $subjectService;
        $this->classService = $classService;
        $this->harmonogramService = $harmonogramService;
        $this->studentService = $studentService;
        $this->teacherService = $teacherService;
    }

    // Save student activity data to student_activity table
    public function storeStudentActivity (Request $request, $subjectName) {

        if (!RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::NOT_ALLOW_CONTENT);

        if (is_null($this->subjectService->getSubjectId($subjectName)))
            return ApiResponse::badRequest(ApiCode::INCORRECT_DATA_REQUEST);


        // Get id of subject which for active students are saving
        $subjectId = $this->subjectService->getSubjectId($subjectName)[0];


        // Get id of class by first identifier from request
        $classId = $this->classService->getClassIdByIdentifier($request[0]['student']['identifier'])[0];


        // Get time from harmonogram to set start time lesson for active list
        $timeActive = $this->harmonogramService->setTimeActive( $subjectId, $classId );
        if ($timeActive == 0)
            return ApiResponse::badRequest(ApiCode::NOTSTORE_STUDENT_ACTIVE);


        // Go through all students from current class
        foreach ( $request->all() as $frequencyItem ) {

            // Map current data to frequency model
            $frequency = new StudentFrequencyWebModel;
            $frequency -> setActive($frequencyItem['isActive']);
            $frequency -> setStudentIdentifier($frequencyItem['student']['identifier']);

            $studentId = $this->classService->getStudentIdByIdentifier($frequency->getStudentIdentifier())[0];


            // Update student frequenty
            $this->teacherService->modifyStudentActive($studentId, $timeActive, $frequency->getActive());
        }


        return ApiResponse::withSuccess(ApiCode::STORE_STUDENT_ACTIVE);
    }


    /**
     * @param $class string The class contains identifier number and number
     * @param $subjectName string The subject that student was active for
     * @param $date string The date contain information about student frequenties
     */
    public function showStudentFrequenty ( string $class, string $subjectName, string $date ) {

        if (!RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::NOT_ALLOW_CONTENT);

        if (is_null($this->subjectService->getSubjectId($subjectName)) || strlen($class) != 2)
            return ApiResponse::badRequest(ApiCode::INCORRECT_DATA_REQUEST);


        // Init list for collect student items with them active
        $studentFrequencyList = new StudentFrequencyListResultApiModel;


        // what the class
        $classNumber = $class[0];
        $identifierClassNumber = $class[1];

        if ( ( !count( $this -> classService -> getClassIdByClassName( $classNumber, $identifierClassNumber ) ) ) > 0 )
            return ApiResponse::badRequest(ApiCode::INCORRECT_DATA_REQUEST);


        // Get id of subject which for active students are displaying
        $subjectId = $this->subjectService->getSubjectId($subjectName)[0];
        $classId = $this->classService->getClassIdByClassName($classNumber, $identifierClassNumber)[0];


        // Check if teacher can update students frequenty
        $timeActive = $this->harmonogramService->setTimeActive( $subjectId, $classId );
        if ($timeActive == 0)
            $studentFrequencyList -> setReadOnly(true);
        else
            $studentFrequencyList -> setReadOnly(false);


        // Set date from request
        $studentFrequencyList -> setDate($date);


        // Retrieve students from request class
        $studentListFromDB = $this->classService->getStudentListByClass($classNumber, $identifierClassNumber);
        foreach ( $studentListFromDB as $studentItemFromDB ) {
            $studentFrequency = new StudentFrequencyResultApiModel;

            // student setails
            $student = new StudentResultApiModel();
            $student->setIdentifier($studentItemFromDB['identifier']);
            $student->setFirstName($studentItemFromDB['first_name']);
            $student->setLastName($studentItemFromDB['last_name']);

            $isActive = $this->studentService->getStudentActivityByStudentIdentifier($student->getIdentifier(), $subjectId, $date);


            // If no one founding return bad request message
            if (is_null($isActive))
                return ApiResponse::badRequest(ApiCode::STUDENT_ACTIVE_NOT_FOUND);


            // student active information
            $studentFrequency->setIsActive($isActive);
            $studentFrequency->setStudent($student);


            // collect data
            $studentFrequencyList->setStudentListActivity($studentFrequency);
            $studentListToDisplay[] = $studentFrequencyList->getStudentListActivity();

        }

        // summary active students list information
        $response = array(
            'readOnly' => $studentFrequencyList -> getReadOnly(),
            'date' => $studentFrequencyList -> getDate(),
            'StudentActivity' => $studentListToDisplay
        );

        // return student list
        return ApiResponse::withSuccess($response);
    }

    public function showStudentMarksOfClassForSubject($subjectName, $class) {

        if (!RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::NOT_ALLOW_CONTENT);

        if (is_null($this->subjectService->getSubjectId($subjectName)) || strlen($class) != 2)
            return ApiResponse::badRequest(ApiCode::INCORRECT_DATA_REQUEST);

        if ( ( !count( $this -> classService -> getClassIdByClassName( $class[0], $class[1] ) ) ) > 0 )
            return ApiResponse::badRequest(ApiCode::INCORRECT_DATA_REQUEST);


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
            $markListItem = $this->studentService->getStudentMarksBySubject($student->getIdentifier(), $subjectName);


            // Initialize student with marks
            $studentWithMarks->setStudent($student);
            $studentWithMarks->setMarks($markListItem);

            // Append next student with his marks to array of all students
            $studentsWithMarks -> setStudentMark($studentWithMarks);
        }


        return ApiResponse::withSuccess( $studentsWithMarks->getStudentMark() );
    }

    public function editStudentMarks( Request $request ) {

        if (!RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::NOT_ALLOW_CONTENT);


        // Initialize mark list with data
        $marksListToEdit = new MarkListEdit();
        $marksListToEdit->setMarkList($request->all());


        // For each item of list
        foreach ( $marksListToEdit->getMarkList() as $item ) {

            // Initialize single mark of item list
            $markItem = new MarkItem();
            $markItem->setMark($item['mark']);
            $markItem->setStudentMarksId($item['student_marks_id']);

            $this->teacherService->modifyStudentMarks($markItem);
        }

        return ApiResponse::withSuccess(null, ApiCode::MARKS_UPDATE_SUCCESS);
    }

    public function insertStudentMark(Request $request) {

        #region Validate

        if (!RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::NOT_ALLOW_CONTENT);

        if (is_null($this->subjectService->getSubjectId($request['name'])))
            return ApiResponse::badRequest(ApiCode::INCORRECT_DATA_REQUEST);

        #endregion

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

        $result = $this->teacherService->storeStudentMarks($markListInsert);


        if (is_null($result))
            return ApiResponse::badRequest(ApiCode::INCORRECT_DATA_REQUEST);

        return ApiResponse::withSuccess(null, ApiCode::MARKS_INSERT_SUCCESS);
    }
}
