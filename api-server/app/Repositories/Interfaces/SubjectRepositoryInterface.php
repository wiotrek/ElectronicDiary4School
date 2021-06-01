<?php


namespace App\Repositories\Interfaces;

use App\Repositories\Base\BaseRepositoryInterface;

interface SubjectRepositoryInterface extends BaseRepositoryInterface {

    /**
     * @return mixed List of subjects which teacher have
     */
    public function readTeacherSubject ();

    /**
     * @return mixed subject name and icon
     */
    public function readStudentSubjects ();

    public function readSubjectIdByName ( $subjectName );

    public function readSubjectNameById ( $subjectId );

    public function readSubjectNameByTeacherId ( $teacherId );

    /**
     * @return boolean true if exist, false otherwise
     */
    public function isSubjectExistByTeacherId ( int $teacherId, int $subjectId );

}
