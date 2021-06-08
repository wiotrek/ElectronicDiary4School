<?php


namespace App\Services;


use App\ApiModels\Marks\Design\MarkItem;
use App\ApiModels\Subject\SubjectDetailsApiModel;
use App\ApiModels\SubjectWithFrequencyResultApiModel;
use App\ApiModels\SubjectWithMarksResultApiModel;
use App\Helpers\KeyColumn;
use App\Helpers\RoleDetecter;
use App\Models\Mark;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Models\StudentStatistics;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\MarkRepository;
use App\Repositories\SubjectRepository;
use App\WebModels\Marks\MarkListInsert;
use Illuminate\Support\Collection;

class StudentService extends BaseRepository {

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


    public function getStudentMarksOfEachSubject( $studentId = null ) {

        if (is_null($studentId))
            $studentId = RoleDetecter::convertToStudentId();

        // This list contain all subject which student have
        $subjectList = $this->getStudentSubject();


        foreach ( $subjectList as $subject ) {

            $subjectDetails = new SubjectDetailsApiModel();
            $subjectWithMarks = new SubjectWithMarksResultApiModel();


            // getting all marks from current subject
            $marks = $this->studentRepository->readStudentMarksBySubjectName($subject['name'], $studentId);
            // Translate marks for api model to studentMarks
            $studentMarks = $this->getStudentMarks($marks);


            // student statistics
            $avgMarks = $this->studentRepository->readAvgMarksBySubjectId(RoleDetecter::convertToStudentId(), $this->subjectRepository->readSubjectIdByName($subject['name'])[0]);
            $avgMarksPosition = $this->studentRepository->readAvgMarksPositionBySubjectName(RoleDetecter::convertToStudentId(), $this->subjectRepository->readSubjectIdByName($subject['name'])[0]);


            // set subject details
            $subjectDetails->setName($subject['name']);
            $subjectDetails->setIcon($subject['icon']);
            $subjectDetails->setMarksAverage(count($avgMarks) == 0 ? null : $avgMarks[0]);
            $subjectDetails->setPosition(count($avgMarksPosition) == 0 ? null : $avgMarksPosition[0]);

            $subjectWithMarks->setSubjectDetails($subjectDetails);


            // collect data from current subject iterate
            $result[] =  array(
                'subject' => $subjectWithMarks->getSubjectDetails(),
                'marks' => $studentMarks == null ? null : $studentMarks
            );

        }

        return $result;
    }

    public function getStudentFrequencyOfEachSubject ($studentId = null) {

        if (is_null($studentId))
            $studentId = RoleDetecter::convertToStudentId();

        // This list contain all subject which student have
        $subjectList = $this->getStudentSubject();

        foreach ( $subjectList as $subject ) {
            $countAbandoned = 0;

            $subjectDetails = new SubjectDetailsApiModel();
            $subjectWithFrequency = new SubjectWithFrequencyResultApiModel();


            // getting all frequency from current subject
            $frequencies = $this->studentRepository->readStudentFrequencyBySubjectName($subject['name'], $studentId);

            foreach ( $frequencies as $frequency ) {

                if ($frequency['active'] == 0) {
                    $countAbandoned++;
                    $subjectWithFrequency -> setDays( substr($frequency[ 'date_active' ], 0, 10) );
                }

            }


            // student statistics
            $frequency = $this->studentRepository->readFrequencyBySubjectId(RoleDetecter::convertToStudentId(), $this->subjectRepository->readSubjectIdByName($subject['name'])[0]);
            $frequencyPosition = $this->studentRepository->readFrequencyPositionBySubjectName(RoleDetecter::convertToStudentId(), $this->subjectRepository->readSubjectIdByName($subject['name'])[0]);


            // set subject details
            $subjectDetails->setName($subject['name']);
            $subjectDetails->setIcon($subject['icon']);
            $subjectDetails->setFrequency(count($frequency) == 0 ? null : $frequency[0]);
            $subjectDetails->setCountAbandoned($countAbandoned);
            $subjectDetails->setPosition(  count($frequencyPosition) == 0 ? null : $frequencyPosition[0] );


            $subjectWithFrequency->setSubjectDetails($subjectDetails);


            // collect data from current subject iterate
            $result[] =  array(
                'subject' => $subjectWithFrequency->getSubjectDetails(),
                'days' => $subjectWithFrequency->getDays() == null ? null : $subjectWithFrequency->getDays()
            );

        }


        return $result;

    }

    #region General Stats

    /**
     * Taking all averages marks from each subject ant compute total average
     */
    public function computeGeneralAverageMarks ( $studentId = null ) {

        // Get student id from param or from auth if is null
        if (is_null($studentId))
            $studentId = RoleDetecter::convertToStudentId();


        // Get all data about marks of student
        $avgMarks = $this->getStudentMarksOfEachSubject($studentId);


        return $this->computeTotalAverage($avgMarks);
    }

    /**
     * Taking general marks average from all student from class which student is and compute his avg marks position on class
     * @param $studentId
     * @param $generalAvgMarks float | null Total averages of marks by specific student
     * @return int|null
     */
    public function computePositionOfGeneralAvgMarks ( $studentId, ?float $generalAvgMarks) {

        // Get student id from param or from auth if is null
        if (is_null($studentId))
            $studentId = RoleDetecter::convertToStudentId();


        $classId = $this->getStudentClassId($studentId);


        // get list of all students from above class id
        $studentIds = $this->classRepository->readStudentsIdByClassId($classId);


        // for each student get general avg marks
        $generalAverageMarks = array(); // Unique values
        foreach ( $studentIds as $id )
            if(count(($this->studentRepository->readListAvgMarks($id))) != 0) {

                // If current avg is not exist inside list of general averake marks then keep flag on one
                $avgMarkCanBeAdd = 1;


                // list of avgs marks from each subject like [2.78 (subject 1), 3.24 (subject 2),...]
                $listAverageMarks = $this -> studentRepository -> readListAvgMarks( $id );


                $avgSum = 0;
                // ...compute avg marks
                foreach ( $listAverageMarks  as $averageMark )
                    $avgSum += $averageMark;


                // Set flag to 0 if avg mark from current student is exist in general list
                foreach ( $generalAverageMarks as $generalAverageMark )
                    if ($generalAverageMark == round($avgSum / count($listAverageMarks), 2))
                        $avgMarkCanBeAdd = 0;


                // Collect every general avg marks from all subject from specific student if the flag is 1
                if ($avgMarkCanBeAdd)
                    $generalAverageMarks[] = round($avgSum / count($listAverageMarks), 2);

            }


        // make sure that any avg mark is in avg marks list
        if (!isset($generalAverageMarks))
            return null;


        // sort average marks in descending way
        arsort($generalAverageMarks);


        $count = 1;
        foreach ( $generalAverageMarks as $generalAverageMark) {
            if ( $generalAverageMark == round($generalAvgMarks, 2) ) {
                $position = $count;
                break;
            }

            $count++;
        }


        return $position ?? null;
    }

    /**
     * Taking frequency values from all subjects and compute average frequency
     */
    public function computeGeneralFrequency ($studentId = null) {
        // Get student id from param or from auth if is null
        if (is_null($studentId))
            $studentId = RoleDetecter::convertToStudentId();


        // Get all data about marks of student
        $avgFrequency = $this->getStudentFrequencyOfEachSubject($studentId);


        return $this->computeTotalAverage($avgFrequency);
    }

    /**
     * Taking average frequency from all subjects of all students from class which student is and compute position of his averag on class
     * @param $studentId
     * @param $generalAvgFrequency mixed Average frequency from all subjects for specific student
     * @return int|null
     */
    public function computePositionOfGeneralAvgFrequency ($studentId, $generalAvgFrequency) {

        // Get student id from param or from auth if is null
        if (is_null($studentId))
            $studentId = RoleDetecter::convertToStudentId();


        $classId = $this->getStudentClassId($studentId);


        // get list of all students from above class id
        $studentIds = $this->classRepository->readStudentsIdByClassId($classId);


        // for each student get all frequency
        $subjectFrequencies = array(); // Unique values
        foreach ( $studentIds as $id )
            if(count($this->studentRepository->readListFrequency($id)) != 0) {

                // If current frequency is not exist inside list of general frequencies then keep flag on one
                $frequencyCanBeAdd = 1;


                // list of frequencies from each subject like [94.46 (subject 1), 100.00 (subject 2),...]
                $listFrequencies = $this -> studentRepository -> readListFrequency( $id );


                $frequencySum = 0;
                // ...get sum of each subject frequency
                foreach ( $listFrequencies  as $subjectFrequency )
                    $frequencySum += $subjectFrequency;


                // Set flag to 0 if frequency from current student is exist in general list
                foreach ( $subjectFrequencies as $frequency )
                    if ( round( $frequency, 2 ) == round( $frequencySum / count( $listFrequencies ), 2 ) )
                        $frequencyCanBeAdd = 0;


                // Collect every general avg marks from all subject from specific student
                if ($frequencyCanBeAdd)
                    $subjectFrequencies[] = $frequencySum / count($listFrequencies);
            }


        // make sure that any avg frequency is in avg frequency list
        if (!isset($subjectFrequencies))
            return null;


        // sort average frequency in descending way
        arsort($subjectFrequencies);


        $count = 1;
        foreach ( $subjectFrequencies as $frequency) {
            if ( round($frequency, 2) == round($generalAvgFrequency, 2) ) {
                $position = $count;
                break;
            }

            $count++;
        }


        return $position ?? $count;
    }

    #endregion

    #endregion

    #region Private Methods

    private function getStudentMarks($marks){
        $subjectWithMarks = new SubjectWithMarksResultApiModel();
        if (count($marks) > 0 && !is_null($marks)) {
            foreach ( $marks as $mark ) {

                $markItem = new MarkItem();

                // for current mark get value and tag name
                $degree = $this->markRepository->readDegreeByMarkId($mark['marks_id']);
                $kindOf = $this->markRepository->readMarkFromByMarkTypeId($mark['marks_type_id']);

                // set mark details
                $markItem->setMark($degree);
                $markItem->setKindOf($kindOf);
                $markItem->setDate(substr($mark['passing_date'], 0, 10));
                $markItem->setTopic($mark['topic']);

                // expand current mark to list of marks for current subject
                $subjectWithMarks->setMarks($markItem);
            }
        }

        return $subjectWithMarks->getMarks();
    }

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


        $classId = $this->getStudentClassId($studentId);


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
        $classId = $this->getStudentClassId($studentId);


        // get list of all students from above class id
        $studentList = $this->classRepository->readStudentsIdByClassId($classId);


        // for each student get all marks
        $averageMarks = array(); // Unique values
        foreach ( $studentList as $student ) {
            // If current mark is not exist inside list of general marks then keep flag on one
            $markCanBeAdd = 1;
            $marks = $this->studentRepository->readStudentMarksBySubjectName($subjectName, $student);


            // getting all marks from current subject
            $studentMarks = $this->getStudentMarks($marks);
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

    private function getStudentClassId($studentId){
        // get class id in which login student is
        $userId = $this->studentRepository->
        findByColumn($studentId, 'student_id', Student::class)->
        pluck('user_id')[0];

        $studentIdentifier = $this->studentRepository->
        findByColumn($userId, 'user_id', User::class)->
        pluck('identifier')[0];

        return $this->classRepository->readClassIdByStudentIdentifier($studentIdentifier);
    }

    /**
     * @param $averages array |null Array of all averages from each subject
     * @return float|int|null
     */
    private function computeTotalAverage( ?array $averages) {
        // Collect only avg marks from all subject
        $avgCollecter = array();


        // It's obvious
        foreach ( $averages as $average )
            foreach ( $average as $item => $value )
                if ( !is_null( $value ) && $item == 'subject' && isset( $value[ 'avg' ] ) ) $avgCollecter[] = $value['avg'];


        $avgSum = 0;
        foreach ( $avgCollecter as $avgItem ) {
            if (is_string($avgItem)) {
                if (strlen($avgItem) > 1) $avgSum += substr( $avgItem, 0, -1 ); }
            else
                $avgSum += $avgItem;
        }

        return count($avgCollecter) > 0 ? ($avgSum / count($avgCollecter)) : null;
    }

    private function createOrUpdateStudentStatistics($studentId, $subjectName) {
        $subjectId = $this->subjectRepository->readSubjectIdByName($subjectName)[0];

        // getting all marks from current subject
        $marks = $this->studentRepository->readStudentMarksBySubjectName($subjectName, $studentId);
        // Translate marks for api model to studentMarks
        $studentMarks = $this->getStudentMarks($marks);


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
    private function updatePositionOfMark( ?Collection $studentList, $subjectId) {

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
