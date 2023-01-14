<?php

namespace App\Http\Controllers;

use App\ApiModels\Base\ApiResponse;
use App\ApiModels\Data\ApiCode;
use App\ApiModels\Marks\MarksItemViewResultApiModel;
use App\ApiModels\StudentResultApiModel;
use App\Helpers\RoleDetecter;
use App\Services\SubjectService;

class SubjectController extends Controller
{
    #region  Private Members

    private $subjectService;

    #endregion

    #region DI Constructor

    public function __construct ( SubjectService $subjectService) {

        $this->subjectService = $subjectService;

    }

    #endregion

    #region Request Methods

    public function showTeacherSubject () {

        if (!RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::NOT_ALLOW_CONTENT);

        $student = new StudentResultApiModel();
        $studentWithMarks = new MarksItemViewResultApiModel();

        $student->setFirstName('first_name');
        $student->setLastName('last_name');
        $student->setIdentifier('identifier');

        $studentWithMarks->setStudent($student);

        return $this->subjectService->getTeacherSubjects();
    }

    #endregion
}
