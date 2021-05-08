<?php


namespace App\Services;

use App\Helpers\DayTranslate;

// Manager date for stored correct time of the students activity
class DateService {

    #region Private Members

    // The flag indicate teacher check active list in correct time
    private $isCanSet = false;


    #endregion

    #region Public Methods

    // Set time as start time redirect to class_harmonogram table
    public function setTimeActive ( $date, $subjectId, $teacherId, $classId  ) {
        #region Test
        $timestamp = strtotime('2021-05-07');
        $day = date('l', $timestamp);

        ( new DayTranslate ) -> fromEngToPl($day);
        $time = date('H:i');
        echo ('time: '.$time)."\n";
        #endregion
    }

    #endregion

    #region Private Methods

    // Check if teacher send list with correct time
    private function IsTeacherLesson (  ) {

    }

    #endregion

}
