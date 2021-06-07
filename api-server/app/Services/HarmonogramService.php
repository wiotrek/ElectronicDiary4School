<?php


namespace App\Services;

use App\DataModels\StartTimeLesson;
use App\Helpers\DayTranslate;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Repositories\Base\BaseRepository;
use App\Repositories\HarmonogramRepository;
use App\Repositories\StudentRepository;
use DateTime;

// Manager date for stored correct time of the students activity
class HarmonogramService extends BaseRepository {

    #region Private Members

    private $harmonogramRepository;
    private $studentRepository;

    // The flag indicate teacher check active list in correct time
    private $isCanSet = false;

    // The name of week
    private $day;

    // The current time
    private $time;

    // The time when lesson is starting
    private $startTime;

    #endregion

    #region Default Constructor

    public function __construct (HarmonogramRepository $harmonogramRepository,
                                 StudentRepository $studentRepository) {
        // Init current day with translated name to polish
        $this->day = ( new DayTranslate ) -> fromEngToPl(date('l'));
        // Init current time with format hour (00-24) and minutes (00-60)
        $this->time = date('H:i');

        $this->harmonogramRepository = $harmonogramRepository;
        $this->studentRepository = $studentRepository;
    }

    #endregion

    #region Public Methods

    /**
     * Set time as start time redirect to class_harmonogram table
     * @param $subjectId
     * @param $classId
     * Return 0 if not founded otherwise time which lesson is starting
     */
    public function setTimeActive ( $subjectId, $classId ) {

        if (!$this->isAnyLessonDuringNow())
            return 0;

       if (!$this->isTeacherHaveLessonNow($subjectId, $classId, $this->startTime ))
            return 0;

       return $this->startTime;

    }

    /**
     * Saving list of activity students list to checking by teacher
     * with default checked status equal 0
     */
    public function initStudentActivityToCheck ( $date, $time ) {

        // Init data
        $getData = $this->harmonogramRepository->readTeachersWhichHaveLessonNow (( new DayTranslate ) -> fromEngToPl(date('l')), date('H:i'));


        // For each row from harmonogram
        foreach ( $getData as $data ) {


            // Init main data
            $teacherId = $data['teacher_id'];
            $subjectId = $data['subject_id'];
            $userClassId = $data['user_class_id'];

            // Get student ids of current review class id
            $studentIds = $this->harmonogramRepository->findIdByOtherId($userClassId, 'user_class_id', 'student_id', Student::class);

            // For each student
            foreach ( $studentIds as $studentId ) {

                // TODO: It's only debug mode. In production set values to 0 above loop
                $activeChance = rand(0, 100);
                $active = $activeChance > 15 ? 1 : 0;
                $checked = 1;

                // Create single row of student_activity table
                $studentActivity = new StudentActivity([
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherId,
                    'active' => $active,
                    'checked' => $checked,
                    'date_active' => $date,
                    'time_active' => $time
                ]);

                $this->studentRepository->saveStudentActivity($studentActivity);
            }

        }
    }

    #endregion

    #region Private Methods

    // Check if teacher send list with correct time
    private function isAnyLessonDuringNow () {

        return !$this -> isWeek() && $this -> isLessonDurring();

    }

    /**
     * Check if sending list is between school work time, between lesson time and the time isn't for break
     * @return bool True if any lesson is during now, false otherwise
     */
    private function isLessonDurring() {
        $startTimeLesson = (new StartTimeLesson)->getConstants();

        foreach ( $startTimeLesson as $start ) {
            $startTime = DateTime::createFromFormat('H:i a', $start);
            $endTime = date('H:i', strtotime('+45 minutes', strtotime($start)));

            if ( $this->time >= $startTime && $this->time <= $endTime ) {
                $this->startTime = $start;
                return true;
            }
        }

        return false;
    }


    /**
     * Check if sending list is behind work days
     * @return bool True if is not work day, false otherwise
     */
    private function isWeek() {

        return $this -> day == DayTranslate::SATURDAY || $this -> day == DayTranslate::SUNDAY;

    }

    /**
     * Check if teacher send list with correct subject for classes with of course time too
     * @return bool false if teacher was wrong otherwise true
     */
    private function isTeacherHaveLessonNow ( $subjectId, $classId, $startTime ) {

        $lessonFounded = $this->harmonogramRepository->isExistLesson($classId, $subjectId, $this->day, $startTime);
        return !( $lessonFounded == 0 );

    }

    #endregion

}
