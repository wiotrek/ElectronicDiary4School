<?php


namespace App\Services;


use App\ApiModels\Marks\Design\MarkItem;
use App\Models\Mark;
use App\Models\StudentActivity;
use App\Models\StudentMark;
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

        // Return empty array if no-one marks founded
        if (is_null($marks))
            return array();

        return $marks;
    }

    /**
     * Checking if any student mark was changing before put to database
     * @param MarkItem $markItem The mark item of list from client
     */
    public function ModifyStudentMarks ( MarkItem $markItem) {

        // mark id represent by mark value from client
        $markIdByMarkFromClient = $this->studentRepository->findByColumn( $markItem->getMark(), 'degree', Mark::class )->pluck('marks_id')[0];

        // mark value from client
        $markFromDb = $this->studentRepository->readStudentMarkByStudentMarkId($markItem->getStudentMarksId())[0];

        // mark id represent by mark value from database
        $markIdFromDb = $this->studentRepository->findByColumn($markFromDb, 'degree', Mark::class)->pluck('marks_id')[0];

        if ($markIdByMarkFromClient != $markIdFromDb && !is_null($markIdFromDb)){

            // Get row to update
            $markToUpdate = $this->studentRepository->findByColumn($markItem->getStudentMarksId(), 'student_marks_id', StudentMark::class)->first();

            // change mark id value
            $markToUpdate->marks_id = $markIdByMarkFromClient;

            $this->studentRepository->updateModel($markItem->getStudentMarksId(), 'student_marks_id', $markToUpdate->marks_id);
        }

    }

    #endregion

}
