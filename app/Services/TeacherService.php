<?php


namespace App\Services;


use App\ApiModels\Marks\Design\MarkItem;
use App\Events\StudentClassIdEvent;
use App\Events\StudentDetailsEvent;
use App\Helpers\KeyColumn;
use App\Models\Mark;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Models\StudentStatistics;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\MarkRepository;
use App\Repositories\SubjectRepository;
use App\WebModels\Marks\MarkListInsert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TeacherService extends BaseRepository {

    #region Private Members

    private $studentRepository;
    private $subjectRepository;
    private $markRepository;
    private $classRepository;
    private $userRepository;

    #endregion

    #region DI Constructor


    public function __construct (StudentRepositoryInterface $studentRepository,
                                 SubjectRepository $subjectRepository,
                                 MarkRepository $markRepository,
                                 ClassRepositoryInterface $classRepository,
                                 UserRepositoryInterface $userRepository) {

        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->markRepository = $markRepository;
        $this->classRepository = $classRepository;

        $this -> userRepository = $userRepository;
    }

    #endregion

    #region Public Methods

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

            if (is_null($marks_id))
                return null;

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


            // It's using for create or update student statistics
            $collectStudentsId[] = $student_id;

        }


        foreach ( $collectStudentsId as $studentId )
            $this->createOrUpdateStudentStatistics($studentId, $mlInsert->getMarkRevision()->getSubject());

        return 1;
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

        // Get row to update
        $markToUpdate = $this->studentRepository->findByColumn($markItem->getStudentMarksId(), 'student_marks_id', StudentMark::class)->first();


        // update if change has detected
        if ($markIdByMarkFromClient != $markIdFromDb && !is_null($markIdFromDb)){


            // change mark id value
            $markToUpdate->marks_id = $markIdByMarkFromClient;


            // update student mark
            $this->studentRepository->updateStudentMarkModel($markItem->getStudentMarksId(), 'student_marks_id', $markToUpdate->marks_id);


            // update student statistics
            $this->createOrUpdateStudentStatistics($markToUpdate->student_id, $this->subjectRepository->readSubjectNameById($markToUpdate->subject_id)[0]);
        }


        $userId = $this->userRepository->readUserIdByStudentId($markToUpdate->student_id);
        $studentIdentifier = $this->userRepository->readIdentifierByUserId($userId);
        $classId = $this->classRepository->readClassIdByStudentIdentifier($studentIdentifier);
        $studentList = $this->classRepository->readStudentsIdByClassId($classId);



        $this->updatePositionOfMark( $studentList, $markToUpdate->subject_id );

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

        $subjectId = $this->studentRepository->readSubjectIdByStudentActiveId($studentActiveId);

        // update student statistics
        $this->createOrUpdateStudentStatistics($studentId, $this->subjectRepository->readSubjectNameById($subjectId)[0]);

    }

    #endregion

    #region Private Methods

    private function computeFrequencyPercent($amountOfflineDays, $amount){
        return $amountOfflineDays > 0 ? (1 - ($amountOfflineDays / $amount)) * 100 : 100;
    }


    private function computeAverageMarks ( $marks ) {

        $avg = 0.0;
        $weightSum = 0;

        if (!is_null($marks)) {
            foreach ( $marks as $mark ) {

                $weight = $this->markRepository->readWeightMarkByMarkFrom( $mark['kindOf']);
                $avg += $mark['mark'] * $weight;
                $weightSum += $weight;

            }
        }

        return $weightSum == 0 ? null : round(($avg / $weightSum), 2);
    }


    private function computePositionOfFrequency ( $subjectName, ?float $studentFrequency, $studentId = null ) {

        // Get student id from param or from auth if is null
        if (is_null($studentId))
            $studentId = $this->studentRepository->getStudentId()[0];


        $classId = event(new StudentClassIdEvent($studentId));


        // get list of all students from above class id
        $studentList = $this->classRepository->readStudentsIdByClassId($classId);


        // for each student get all frequencies
        $percentFrequencies = array();
        foreach ( $studentList as $student ) {
            $frequencyCanBeAdd = 1;

            $frequencies = $this->studentRepository->readStudentFrequencyBySubjectName($subjectName, $student);
            $countAbandoned = 0;

            // Count all offline days that current student was absent
            foreach ( $frequencies as $frequency ) {

                if ($frequency['active'] == 0) {
                    $countAbandoned++;
                }

            }


            $percentFrequency = $this->computeFrequencyPercent($countAbandoned, count($frequencies));


            foreach ( $percentFrequencies as $frequency ) {
                if ($frequency[0] == $percentFrequency)
                    $frequencyCanBeAdd = 0;
            }


            if ($frequencyCanBeAdd)
                $percentFrequencies[] = array($percentFrequency);

        }


        // sort frequencies in descending way
        arsort($percentFrequencies);


        // get position where student percent frequencies is equal avg in array
        $count = 1;
        foreach ( $percentFrequencies as $value) {

            if ( $studentFrequency == $value[0] ) {  $position = $count; break; }
            $count++;

        }

        return $position;
    }


    private function computePositionOfAverageMarks ( $subjectName, ?float $studentAvg, $studentId ) {

        if (is_null($studentAvg))
            return null;


        // get class id in which student is
        $classId = event(new StudentClassIdEvent($studentId));


        // get list of all students from above class id
        $studentList = $this->classRepository->readStudentsIdByClassId($classId);


        // for each student get all marks
        $averageMarks = array(); // Unique values
        foreach ( $studentList as $student ) {
            // If current mark is not exist inside list of general marks then keep flag on one
            $markCanBeAdd = 1;
            $marks = $this->studentRepository->readStudentMarksBySubjectName($subjectName, $student);


            // getting all marks from current subject
            $studentMarks = event(new StudentDetailsEvent($marks));
            // Translate marks for api model to studentMarks
            $avgStudentMarks = $this->computeAverageMarks($studentMarks);


            // Set flag to 0 if duplicate is detected
            foreach ( $averageMarks as $averageMark )
                if ($avgStudentMarks == $averageMark[0])
                    $markCanBeAdd = 0;


            if ($markCanBeAdd)
                $averageMarks[] = array($avgStudentMarks);
        }


        // sort average marks in descending way
        arsort($averageMarks);


        // get position where student avg marks is equal avg in array
        $count = 1;
        foreach ( $averageMarks as $value) {
            if ( $studentAvg == $value[ 0 ] ) {
                $position = $count;
                break;
            }

            $count++;
        }


        return $position;
    }


    private function createOrUpdateStudentStatistics($studentId, $subjectName) {
        $subjectId = $this->subjectRepository->readSubjectIdByName($subjectName)[0];

        // getting all marks from current subject
        $marks = $this->studentRepository->readStudentMarksBySubjectName($subjectName, $studentId);
        // Translate marks for api model to studentMarks
        $studentMarks = event(new StudentDetailsEvent($marks));


        $average = $this->computeAverageMarks($studentMarks);
        $averagePosition = $this->computePositionOfAverageMarks($subjectName, $average, $studentId);


        $frequencies = $this->studentRepository->readStudentFrequencyBySubjectName($subjectName, $studentId);
        $countAbandoned = 0;
        if (count($frequencies) != 0) {
            foreach ( $frequencies as $frequency ) {
                if ( $frequency[ 'active' ] == 0 )
                    $countAbandoned++;
            }

            $frequency = $this -> computeFrequencyPercent( $countAbandoned, count( $frequencies ) );
            $frequencyPosition = $this -> computePositionOfFrequency( $subjectName, $frequency, $studentId );
        }
        else {
            $frequency = null;
            $frequencyPosition = null;
        }


        $studentStatistics = new StudentStatistics();

        $studentStatistics->student_id = $studentId;
        $studentStatistics->subject_id = $subjectId;
        $studentStatistics->average_marks = $average;
        $studentStatistics->average_position = $averagePosition;
        $studentStatistics->frequency = $frequency;
        $studentStatistics->frequency_position = $frequencyPosition;


        $statisticsId = $this->studentRepository->readStudentStatisticsId($studentId, $subjectId);
        if (count($statisticsId) == 0)
            $this->storeModel($studentStatistics);
        else
            $this->studentRepository->updateStudentStatistics ( $statisticsId[0], KeyColumn::fromModel(StudentStatistics::class), $studentStatistics );

    }

    /**
     * After each updating student marks, update average positions for rest students from the same class
     * @param Collection|null $studentList array | null The list of student ids
     * @param $subjectId int
     */
    private function updatePositionOfMark( ?Collection $studentList, int $subjectId) {

        // Keep average reference to student id from student list
        $markDetails = [];


        // Fill mark details of each student
        foreach ( $studentList as $studentId ) {

            // Read for this student his average by subject id
            $statisticsModel = $this->studentRepository->readStudentStatisticsById($studentId, $subjectId);
            $markDetails[] = array(
                'studentId' => $studentId,
                'average' =>$statisticsModel['average_marks']
            );

        }


        // Sorting by average column
        $averages = array_column($markDetails, 'average');
        array_multisort($averages, SORT_DESC, $markDetails);


        // Calculate position for average mark
        $newPositions = array();
        $count = 1; // Specific position
        foreach ( $markDetails as $markDetail ) {
            $markCanBeAdd = 1;

            // Set flag to 0 if duplicate is detected
            foreach ( $newPositions as $value )
                if ($value['avg'] == $markDetail['average'])
                    $markCanBeAdd = 0;

            // For unique average set next position
            if ($markCanBeAdd)
                $newPositions[] = array(
                    'pos' => $count++,
                    'avg' => $markDetail['average']
                );

        }


        // Finally, for each student update avg position with new
        foreach ( $markDetails as $markDetail ) {

            // Init data
            $settingPosition = 0;
            $statisticsModel = $this->studentRepository->readStudentStatisticsById($markDetail['studentId'], $subjectId);

            // Set new position for right avg
            foreach ( $newPositions as $value ) {
                if ($markDetail['average'] == $value['avg'])
                    $settingPosition = $value['pos'];
            }

            $statisticsModel->average_position = $settingPosition;

            $statisticsId = $this->studentRepository->readStudentStatisticsId($markDetail['studentId'], $subjectId);
            if (count($statisticsId) != 0)
                $this->studentRepository->updateStudentStatistics ( $statisticsId[0], KeyColumn::fromModel(StudentStatistics::class), $statisticsModel );

        }

    }

    #endregion

}
