<?php


namespace App\Repositories\Interfaces;

use App\Repositories\Base\BaseRepositoryInterface;

interface SubjectRepositoryInterface extends BaseRepositoryInterface {

    /**
     * @return mixed List of subjects which teacher have
     */
    public function readTeacherSubject ();

    /**
     * @return mixed List of subjects which student have
     */
    public function readStudentSubjects ();

    public function readSubjectIdByName ( $subjectName );

    public function readSubjectNameById ( $subjectId );

}
