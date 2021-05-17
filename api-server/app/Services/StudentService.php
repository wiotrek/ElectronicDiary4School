<?php


namespace App\Services;


use App\ApiModels\Marks\Design\MarkItem;
use App\ApiModels\Marks\Design\MarkWithTagItem;
use App\ApiModels\SubjectWithMarksResultApiModel;
use App\Helpers\KeyColumn;
use App\Models\Mark;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\MarkRepository;
use App\Repositories\SubjectRepository;
use App\WebModels\Marks\MarkListInsert;
use Illuminate\Database\Eloquent\Model;

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

            $this->studentRepository->updateStudentMarkModel($markItem->getStudentMarksId(), 'student_marks_id', $markToUpdate->marks_id);
        }

    }



    /**
     * @param $studentId int The value of the primary key from Student table
     * @param $timeActive string The current time which lesson during now
     * @param $isActive bool The flag indicates that student is present or not
     */
    public function modifyStudentActive ( int $studentId, string $timeActive, bool $isActive ) {
        $studentActiveId = $this->studentRepository->readStudentActiveIdByStudentIdAndDate($studentId, date('Y-m-d'), $timeActive)[0];

        // Get specific student active
        $studentActiveToUpdate = $this->studentRepository->findByColumn($studentId, KeyColumn::fromModel(Student::class), StudentActivity::class)->first();
        // Set new value for this student
        $studentActiveToUpdate->active = $isActive;

        $this->studentRepository->updateStudentActiveModel($studentActiveId, KeyColumn::fromModel(StudentActivity::class), $studentActiveToUpdate->active);
    }


    public function getStudentMarksBySubject ( $identifier, $subjectName ) {

        // Get student marks by params
        $marks = $this->studentRepository->readStudentMarksBySubjectAndIdentifier($identifier, $subjectName);

        // Return empty array if no-one marks founded
        if (is_null($marks))
            return array();

        return $marks;
    }


    public function getStudentActivityByStudentIdentifier ( $studentIdentifier, $subjectId, $date ) {

        $studentId = $this->studentRepository->readStudentIdByIdentifier($studentIdentifier)[0];

        return $this->studentRepository->readStudentActive($studentId, $subjectId, $date);
    }


    public function getStudentSubject ( ) {

        return $this->subjectRepository->readStudentSubjects();
    }


    public function getStudentMarksOfEachSubject(  ) {

        // This list contain all subject which student have
        $subjectList = $this->getStudentSubject();


        foreach ( $subjectList as $subject ) {

           $subjectWithMarks = new SubjectWithMarksResultApiModel();
           $subjectWithMarks->setSubjectDetails($subject);


            // getting all marks from current subject
            $marks = $this->studentRepository->readStudentMarksBySubject($subject);


            // get data from this list of marks which contain at least one mark
            if (count($marks) > 0 && !is_null($marks)) {
                foreach ( $marks as $mark ) {

                    $markWithTag = new MarkWithTagItem();

                    // for current mark get value and tag name
                    $degree = $this->markRepository->readDegreeByMarkId($mark['marks_id']);
                    $tag = $this->markRepository->readMarkFromByMarkTypeId($mark['marks_type_id']);

                    // set mark details
                    $markWithTag->setMarkValue($degree);
                    $markWithTag->setTagName($tag[0]);

                    // expand current mark to list of marks for current subject
                    $subjectWithMarks->setMarks($markWithTag);
                }
            }

            // collect data from current subject iterate
            $result[] =  array(
                'subject' => $subjectWithMarks->getSubjectDetails(),
                'marks' => $subjectWithMarks->getMarks() == null ? 'brak' : $subjectWithMarks->getMarks()
            );

        }


        return $result;
    }

    #endregion

}
