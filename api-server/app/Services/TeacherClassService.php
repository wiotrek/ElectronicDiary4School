<?php


namespace App\Services;


use App\DataModels\IconClass;
use App\Icons\IconGenerator;
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

    public function getTeacherClasses (  ) {
        $teachersClasses = $this->classRepository->readTeacherClasses();

        if (is_null($teachersClasses))
            return null;


        return $teachersClasses;
    }

    #endregion

}
