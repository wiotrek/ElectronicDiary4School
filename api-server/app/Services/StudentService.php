<?php


namespace App\Services;


use App\Models\StudentActivity;
use App\Repositories\Interfaces\StudentRepositoryInterface;

class StudentService {

    #region Private Members

    private $studentRepository;

    #endregion

    #region DI Constructor

    public function __construct (StudentRepositoryInterface $studentRepository) {
        $this->studentRepository = $studentRepository;
    }

    #endregion

    #region Public Methods

    public function storeStudentActivity ( StudentActivity $studentActivity ) {
        $this->studentRepository->saveStudentActivity($studentActivity);
    }

    #endregion

}
