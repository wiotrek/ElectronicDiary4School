<?php


namespace App\Services;


use App\ApiModels\Marks\Design\MarkItem;
use App\Models\Mark;
use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\MarkRepository;
use App\Repositories\SubjectRepository;
use App\WebModels\Marks\MarkListInsert;

class StudentService {

    #region Private Members

    private $studentRepository;
    private $subjectRepository;
    private $markRepository;

    #endregion

    #region DI Constructor

    public function __construct (StudentRepositoryInterface $studentRepository,
                                 SubjectRepository $subjectRepository,
                                 MarkRepository $markRepository) {
        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->markRepository = $markRepository;
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
    public function modifyStudentMarks ( MarkItem $markItem) {

        // mark id from database represent by mark value from client
        $markIdByMarkFromClient = $this->studentRepository->findByColumn( $markItem->getMark(), 'degree', Mark::class )->pluck('marks_id')[0];

        // mark value from database represent by student marks id from client
        $markFromDb = $this->studentRepository->readStudentMarkByStudentMarkId($markItem->getStudentMarksId())[0];

        // mark id from database represent by mark value from database
        $markIdFromDb = $this->markRepository->readMarkIdByDegree($markFromDb);


        // update if change has detected
        if ($markIdByMarkFromClient != $markIdFromDb && !is_null($markIdFromDb)){

            // Get row to update
            $markToUpdate = $this->studentRepository->findByColumn($markItem->getStudentMarksId(), 'student_marks_id', StudentMark::class)->first();

            // change mark id value
            $markToUpdate->marks_id = $markIdByMarkFromClient;

            $this->studentRepository->updateModel($markItem->getStudentMarksId(), 'student_marks_id', $markToUpdate->marks_id);
        }

    }

    public function storeStudentMarks ( MarkListInsert $mlInsert ) {

        // Initialize value
        $subject_id = $this->subjectRepository->readSubjectIdByName($mlInsert->getMarkRevision()->getSubject())[0];
        $marks_type_id = $this->markRepository->readMarkTypeIdByMarkFrom($mlInsert->getMarkRevision()->getKindOf());
        $approach_number = 1;
        $topic = $mlInsert->getMarkRevision()->getTopic();
        $passing_date = $mlInsert->getMarkRevision()->getDate();

        // For each student his mark
        foreach ( $mlInsert->getMarks() as $mark ) {

            // Declare eloquent model
            $studentMark = new StudentMark();

            // Initialize mark current mark data
            $student_id = $this->studentRepository->readStudentIdByIdentifier($mark->getIdentifier())[0];
            $marks_id = $this->markRepository->readMarkIdByDegree($mark->getMark());

            // Fill eloquent columns
            $studentMark->student_id = $student_id;
            $studentMark->marks_id = $marks_id;
            $studentMark->subject_id = $subject_id;
            $studentMark->marks_type_id = $marks_type_id;
            $studentMark->approach_number = $approach_number;
            $studentMark->topic = $topic;
            $studentMark->passing_date = $passing_date;

            // Store current row to database
            $this->studentRepository->storeStudentMark($studentMark);
        }

    }
    #endregion

}
