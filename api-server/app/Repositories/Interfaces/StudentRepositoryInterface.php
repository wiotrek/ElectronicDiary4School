<?php


namespace App\Repositories\Interfaces;


use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Repositories\Base\BaseRepositoryInterface;

interface StudentRepositoryInterface extends BaseRepositoryInterface {

    /**
     * @param $activity StudentActivity Model with data to store
     * @return mixed
     */
    public function saveStudentActivity ( StudentActivity $activity );

    /**
     * @param StudentMark $studentMarkEloquent Model with data to store
     * @return mixed
     */
    public function storeStudentMark ( StudentMark $studentMarkEloquent );

    /**
     * @param $identifier string User identifier
     * @return int student_id from student table
     */
    public function readStudentIdByIdentifier( string $identifier );

    /**
     * @param $identifier string The student identifier
     * @param $subjectName string the subject student get marks from
     * @return array | null The marks of specific student
     */
    public function readStudentMarksBySubject ( string $identifier, string $subjectName );

    /**
     * @param $studentMarkId int The primary key of the student_marks table
     * @return mixed The mark id from marks table for this id
     */
    public function readStudentMarkByStudentMarkId ( int $studentMarkId );

    /**
     * @param $primaryKey int
     * @param $primaryColumnName string
     * @param $valueToUpdate mixed
     * @return mixed
     */
    public function updateModel ( int $primaryKey, string $primaryColumnName, $valueToUpdate);

}
