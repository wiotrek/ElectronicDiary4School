<?php


namespace App\Services;


use App\ApiModels\Marks\Design\MarkItem;
use App\ApiModels\Marks\Design\MarkWithTagItem;
use App\ApiModels\Subject\SubjectDetailsApiModel;
use App\ApiModels\SubjectWithFrequencyResultApiModel;
use App\ApiModels\SubjectWithMarksResultApiModel;
use App\Helpers\KeyColumn;
use App\Models\Mark;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\MarkRepository;
use App\Repositories\SubjectRepository;
use App\WebModels\Marks\MarkListInsert;
use Illuminate\Database\Eloquent\Model;

class StudentService extends BaseRepository {

    #region Private Members

    private $studentRepository;
    private $subjectRepository;
    private $markRepository;
    private $classRepository;

    #endregion

    #region DI Constructor

    public function __construct (StudentRepositoryInterface $studentRepository,
                                 SubjectRepository $subjectRepository,
                                 MarkRepository $markRepository,
                                 ClassRepositoryInterface $classRepository) {
        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->markRepository = $markRepository;
        $this->classRepository = $classRepository;
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


    public function getStudentMarksOfEachSubject( $studentId = null ) {

        if (is_null($studentId))
            $studentId = $this->studentRepository->getStudentId();

        // This list contain all subject which student have
        $subjectList = $this->getStudentSubject();


        foreach ( $subjectList as $subject ) {

            $subjectDetails = new SubjectDetailsApiModel();
            $subjectWithMarks = new SubjectWithMarksResultApiModel();


            // getting all marks from current subject
            $marks = $this->studentRepository->readStudentMarksBySubjectName($subject['name'], $studentId);
            // Translate marks for api model to studentMarks
            $studentMarks = $this->getStudentMarks($marks);


            // set subject details
            $subjectDetails->setName($subject['name']);
            $subjectDetails->setIcon($subject['icon']);
            $subjectDetails->setMarksAverage($this->computeAverageMarks($studentMarks));
            $subjectDetails->setPosition($this->computePositionOfAverageMarks ( $subjectDetails->getName(), $subjectDetails->getMarksAverage(), $studentId ));


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
            $studentId = $this->studentRepository->getStudentId();

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

            $frequency = $this->computeFrequencyPercent($countAbandoned, count($frequencies));

            // set subject details
            $subjectDetails->setName($subject['name']);
            $subjectDetails->setIcon($subject['icon']);
            $subjectDetails->setFrequency($frequency.'%');
            $subjectDetails->setCountAbandoned($countAbandoned);
            $subjectDetails->setPosition($this->computePositionOfFrequency($subjectDetails->getName(), $frequency));


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
            $studentId = $this->studentRepository->getStudentId()[0];


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
            $studentId = $this->studentRepository->getStudentId()[0];


        $classId = $this->getStudentClassId($studentId);


        // get list of all students from above class id
        $studentList = $this->classRepository->readStudentsIdByClassId($classId);


        // for each student get all marks
        foreach ( $studentList as $student )
            if(!is_null($this->computeGeneralAverageMarks($student)))
                $generalAverageMarks[] = $this->computeGeneralAverageMarks($student);


        // make sure that any avg mark is in avg marks list
        if (!isset($generalAverageMarks))
            return null;


        // sort average marks in descending way
        arsort($generalAverageMarks);


        $count = 1;
        foreach ( $generalAverageMarks as $generalAverageMark) {
            if ( $generalAverageMark == $generalAvgMarks ) {
                $position = $count;
                break;
            }

            $count++;
        }


        return $position;
    }

    /**
     * Taking frequency values from all subjects and compute average frequency
     */
    public function computeGeneralFrequency ($studentId = null) {
        // Get student id from param or from auth if is null
        if (is_null($studentId))
            $studentId = $this->studentRepository->getStudentId()[0];


        // Get all data about marks of student
        $avgMarks = $this->getStudentFrequencyOfEachSubject($studentId);


        return $this->computeTotalAverage($avgMarks);
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
            $studentId = $this->studentRepository->getStudentId()[0];


        $classId = $this->getStudentClassId($studentId);


        // get list of all students from above class id
        $studentList = $this->classRepository->readStudentsIdByClassId($classId);


        // for each student get all marks
        foreach ( $studentList as $student )
            if(!is_null($this->computeGeneralFrequency($student)))
                $generalAverageFrequencies[] = $this->computeGeneralFrequency($student);


        // make sure that any avg mark is in avg marks list
        if (!isset($generalAverageFrequencies))
            return null;


        // sort average marks in descending way
        arsort($generalAverageFrequencies);


        $count = 1;
        foreach ( $generalAverageFrequencies as $frequency) {
            if ( $frequency == $generalAvgFrequency ) {
                $position = $count;
                break;
            }

            $count++;
        }


        return $position;
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

    private function computePositionOfFrequency ( $subjectName, ?float $studentFrequency ) {

        // get class id in which login student is
        $studentIdentifier = $this->studentRepository->
        findByColumn($this->studentRepository->getAuthId(), 'user_id', User::class)->
        pluck('identifier')[0];

        $classId = $this->classRepository->readClassIdByStudentIdentifier($studentIdentifier);


        // get list of all students from above class id
        $studentList = $this->classRepository->readStudentsIdByClassId($classId);


        // for each student get all frequencies
        foreach ( $studentList as $student ) {

            $frequencies = $this->studentRepository->readStudentFrequencyBySubjectName($subjectName, $student);
            $countAbandoned = 0;

            // Count all offline days that current student was absent
            foreach ( $frequencies as $frequency ) {

                if ($frequency['active'] == 0) {
                    $countAbandoned++;
                }

            }

            $percentFrequency = $this->computeFrequencyPercent($countAbandoned, count($frequencies));
            $percentFrequencies[] = array($percentFrequency);

        }

        // sort frequencies in descending way
        arsort($percentFrequencies);


        // get position where student percent frequencies is equal avg in array
        $count = 1;
        foreach ($percentFrequencies as $key => $value) {

            if ( $studentFrequency == $value[0] ) {  $position = $count; break; }
            $count++;

        }

        return $position;
    }

    private function computePositionOfAverageMarks ( $subjectName, ?float $studentAvg, $studentId ) {

        if (is_null($studentAvg))
            return 'brak ocen';


        // get class id in which student is
        $classId = $this->getStudentClassId($studentId); //$this->classRepository->readClassIdByStudentIdentifier($studentIdentifier);


        // get list of all students from above class id
        $studentList = $this->classRepository->readStudentsIdByClassId($classId);


        // for each student get all marks
        foreach ( $studentList as $student ) {
            $marks = $this->studentRepository->readStudentMarksBySubjectName($subjectName, $student);

            // invoke computeAverageMarks method
            $studentMarks = $this->getStudentMarks($marks);
            $avgStudentMarks = $this->computeAverageMarks($studentMarks);

            $averageMarks[] = array($avgStudentMarks);
        }


        // sort average marks in descending way
        arsort($averageMarks);


        // get position where student avg marks is equal avg in array
        $count = 1;
        foreach ($averageMarks as $key => $value) {
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
            if (is_string($avgItem))
                $avgSum += substr( $avgItem, 0, -1 );
            else
                $avgSum += $avgItem;
        }

        return count($avgCollecter) > 0 ? ($avgSum / count($avgCollecter)) : null;
    }

    #endregion

}
