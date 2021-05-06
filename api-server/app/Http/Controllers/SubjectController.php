<?php

namespace App\Http\Controllers;

use App\ApiModels\Marks\MarksItemViewResultApiModel;
use App\ApiModels\StudentResultApiModel;
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
