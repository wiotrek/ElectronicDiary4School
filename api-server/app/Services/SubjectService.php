<?php


namespace App\Services;

use App\Models\Subject;
use App\Repositories\Interfaces\SubjectRepositoryInterface;

class SubjectService {

    #region Private Members

    private $subjectRepository;

    #endregion

    #region DI Constructor

    public function __construct (SubjectRepositoryInterface $subjectRepository) {
        $this->subjectRepository = $subjectRepository;
    }

    #endregion

    #region Public Methods

    public function getTeacherSubjects (  ) {

        $teachersSubjects = $this->subjectRepository->readTeacherSubject();

        if (is_null($teachersSubjects))
            return null;

        return $teachersSubjects;

    }


    public function getSubjectId ( $subjectName ) {
        return $this->subjectRepository->findByColumn($subjectName, 'name', Subject::class)
            ->pluck('subject_id');
    }


    public function getAllSubjects (  ) {
        return $this->subjectRepository->readAll();
    }

    #endregion

}
