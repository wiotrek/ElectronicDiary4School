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

        if (!$this->subjectRepository->isSubjectExistBySubjectName($subjectName))
            return null;

        return $this->subjectRepository->findByColumn($subjectName, 'name', Subject::class)
            ->pluck('subject_id');
    }


    //TODO: Create Singleton Session class contains all information about login user
    public function getTeacherId ( ) {
        return $this->subjectRepository->getTeacherId();
    }

    #endregion

}
