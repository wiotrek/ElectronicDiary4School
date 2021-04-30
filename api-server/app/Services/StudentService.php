<?php


namespace App\Services;


use App\ApiModels\Marks\Design\MarkItem;
use App\ApiModels\Marks\Design\MarkListItem;
use App\ApiModels\StudentResultApiModel;
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

    public function getStudentMarksBySubject ( $identifier, $subjectName ) {
        // Get student marks by params
        $marks = $this->studentRepository->readStudentMarksBySubject($identifier, $subjectName);

        // Create array for marks
        $markListItem = new MarkListItem();

        // Return empty object if no-one marks founded
        if (is_null($marks))
            return $markListItem;


        // otherwise for each mark
        foreach ( $marks as $mark ) {

            // Create next mark
            $markItem = new MarkItem;

            // Initialize details of the current mark
            $markItem -> setMark( $mark[ 'mark' ] );
            $markItem -> setTopic( $mark[ 'topic' ] );
            $markItem -> setKindOf( $mark[ 'kindOf' ] );

            // Append current mark to array marks of student
            $markListItem -> setMarks( $markItem );
        }


        return $markListItem;
    }

    #endregion

}
