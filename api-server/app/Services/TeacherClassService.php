<?php


namespace App\Services;


use App\Repositories\ClassRepositoryInterface;

class TeacherClassService {

    #region Private Members

    private $classRepository;

    #endregion

    #region DI Constructor

    public function __construct (ClassRepositoryInterface $classRepository) {
        $this->classRepository = $classRepository;
    }

    #endregion

    #region Implemented Methods

    public function getTeacherClasses ( $subjectName ) {
        if (!is_null($subjectName))
            $teachersClasses = $this->classRepository->readTeacherClasses($subjectName);
        else
            return null;

        if (is_null($teachersClasses))
            return null;


        return $teachersClasses;
    }

    #endregion

}
