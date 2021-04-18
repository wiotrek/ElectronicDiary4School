<?php


namespace App\Services;

use App\Repositories\SubjectRepositoryInterface;

class TeacherSubjectService {

    #region Private Members

    private $subjectRepository;

    #endregion

    #region DI Constructor

    public function __construct (SubjectRepositoryInterface $subjectRepository) {
        $this->subjectRepository = $subjectRepository;
    }

    #endregion

    #region Implemented Methods

    public function getTeacherSubjects (  ) {

        $teachersSubjects = $this->subjectRepository->readTeacherSubject();

        if (is_null($teachersSubjects))
            return null;

        return $teachersSubjects;

    }

    public function getAllSubjects (  ) {
        return $this->subjectRepository->readAll();
    }

    #endregion

}
