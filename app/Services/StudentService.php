<?php


namespace App\Services;

use App\ApiModels\Subject\SubjectDetailsApiModel;
use App\ApiModels\SubjectWithFrequencyResultApiModel;
use App\ApiModels\SubjectWithMarksResultApiModel;
use App\Events\StudentClassIdEvent;
use App\Events\StudentDetailsEvent;
use App\Helpers\RoleDetecter;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\SubjectRepository;

class StudentService extends BaseRepository {

    #region Private Members

    private $studentRepository;
    private $subjectRepository;
    private $classRepository;

    #endregion

    #region DI Constructor

    public function __construct (StudentRepositoryInterface $studentRepository,
                                 SubjectRepository $subjectRepository,
                                 ClassRepositoryInterface $classRepository) {

        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->classRepository = $classRepository;
    }

    #endregion

    #region Public Methods

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
            $studentMarks = event(new StudentDetailsEvent($marks));


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
                'marks' => $studentMarks == null ? null : $studentMarks[0]
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


        $classId = event(new StudentClassIdEvent($studentId));


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


        $classId = event(new StudentClassIdEvent($studentId));


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

    #endregion

}
