<?php


namespace App\Repositories\Interfaces;


use App\Repositories\Base\BaseRepositoryInterface;

interface HarmonogramRepositoryInterface extends BaseRepositoryInterface {

    /**
     * Check if teacher have lesson by provided args
     * @param $classId int
     * @param $subjectId int
     * @param $day string The name of day in polish language
     * @param $startTime string The time with format H:i which lesson is starting
     * @return int primary key if founded, 0 otherwise
     */
    public function isExistLesson ( int $classId, int $subjectId, string $day, string $startTime );

    /**
     * // Get all data needed to save on first time to student_activity table
     * @param string $day Current translated name to polish of day
     * @param string $time The current time with format H:i
     * @return mixed teacher id, subject id, user class id
     */
    public function readTeachersWhichHaveLessonNow (string $day, string $time);

    /**
     * Get all teachers which teach specify class
     * @param int $userClassId
     * @return mixed teacher name, teacher last name, teacher identifier, subject name
     */
    public function readTeacherListWhichClassTeach (int $userClassId);

    public function readTeacherClassListBySubjectId ( int $subjectId, int $teacherId = null );

}
