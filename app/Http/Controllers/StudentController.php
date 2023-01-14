<?php

namespace App\Http\Controllers;

use App\ApiModels\Base\ApiResponse;
use App\ApiModels\Data\ApiCode;
use App\ApiModels\Subject\SubjectApiModel;
use App\Helpers\RoleDetecter;
use App\Services\StudentService;

class StudentController extends Controller
{

    private $studentService;

    public function __construct( StudentService $studentService )
    {
        $this->studentService = $studentService;
    }

    public function studentSubjects () {

        // If teacher trying view subjects for student and their parents, return no unauth
        if (RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::IS_NOT_TEACHER_CONTENT);


        // Data from DB
        $result = $this->studentService->getStudentSubject();


        if  (is_null($result))
            return ApiResponse::badRequest(ApiCode::STUDENT_SUBJECTS_NOT_FOUND);


        foreach ( $result as $item ) {

            // Of course result contain exactly key-value pair what I'm doing here but i prefer have control with ...
            $subjectApiModel = new SubjectApiModel();
            $subjectApiModel->setName($item['name']);
            $subjectApiModel->setIcon($item['icon']);

            //... setting key
            $response[] = array(
                'name' => $subjectApiModel->getName(),
                'icon' => $subjectApiModel->getIcon(),
            );

        }

        return ApiResponse::withSuccess($response);
    }


    public function showMarksOfEachSubject (  ) {


        if (RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::IS_NOT_TEACHER_CONTENT);

        $subjectWithMarks = $this->studentService->getStudentMarksOfEachSubject();


        return ApiResponse::withSuccess($subjectWithMarks);
    }

    public function showFrequencyOfEachSubject () {

        if (RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::IS_NOT_TEACHER_CONTENT);

        $subjectWithFrequency = $this->studentService->getStudentFrequencyOfEachSubject();

        return ApiResponse::withSuccess($subjectWithFrequency);
    }


    public function showAverageMarks () {

        if (RoleDetecter::isTeacher())
            return ApiResponse ::unAuthenticated( ApiCode::IS_NOT_TEACHER_CONTENT );

        $averageMarks = $this->studentService->computeGeneralAverageMarks();
        $position = $this->studentService->computePositionOfGeneralAvgMarks(null, $averageMarks);

        return ApiResponse::withSuccess(array(
            array(
                'caption' => is_null($averageMarks) ? null : round($averageMarks, 2),
                'name' => RoleDetecter::isStudent() ? 'Średnia ze wszystkich przedmiotów' : 'Średnia dziecka'
            ) ,
            array(
                'caption' => is_null($position) ? null : $position,
                'name' => RoleDetecter::isStudent() ? 'Pozycja na tle klasy' : 'Pozycja na tle innych dzieci'
            ))
        );
    }


    public function showAverageFrequency () {

        if (RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::IS_NOT_TEACHER_CONTENT);

        $averageFrequency = $this->studentService->computeGeneralFrequency();
        $position = $this->studentService->computePositionOfGeneralAvgFrequency(null, $averageFrequency);

        return ApiResponse::withSuccess(array(
            array(
                'caption' => is_null($averageFrequency) ? null : round($averageFrequency, 2).'%',
                'name' => RoleDetecter::isStudent() ?  'Ogólna frekwencja' : 'Frekwencja dziecka'
            ) ,
            array(
                'caption' => is_null($position) ? null : $position,
                'name' => RoleDetecter::isStudent() ?  'Twoja pozycja w klasie' : 'Pozycja na tle innych dzieci'
            ))
        );
    }

}
