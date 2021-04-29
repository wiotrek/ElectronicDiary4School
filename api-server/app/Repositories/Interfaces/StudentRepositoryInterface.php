<?php


namespace App\Repositories\Interfaces;


use App\Models\StudentActivity;
use App\Repositories\Base\BaseRepositoryInterface;

interface StudentRepositoryInterface extends BaseRepositoryInterface {

    /**
     * @param $activity StudentActivity Model with data to store
     * @return mixed
     */
    public function saveStudentActivity ( StudentActivity $activity );

    /**
     * @param $identifier string The student identifier
     * @param $subjectName string the subject student get marks from
     * @return array | null The marks of specific student
     */
    public function readStudentMarksBySubject ( string $identifier, string $subjectName );

}
