<?php

namespace App\Http\Controllers;

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

        return $this->subjectService->getTeacherSubjects();

    }

    public function showAllSubject (  ) {
        return $this->subjectService->getAllSubjects();
    }

    #endregion
}
