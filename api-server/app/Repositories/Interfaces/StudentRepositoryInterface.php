<?php


namespace App\Repositories\Interfaces;


use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Repositories\Base\BaseRepositoryInterface;

interface StudentRepositoryInterface extends BaseRepositoryInterface {

    #region Saving

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

    #endregion

    #region Updating

    /**
     * @param $primaryKey int
     * @param $primaryColumnName string
     * @param $valueToUpdate mixed
     * @return mixed
     */
    public function updateStudentMarkModel ( int $primaryKey, string $primaryColumnName, $valueToUpdate);

    /**
     * @param $primaryKey
     * @param $primaryColumnName
     * @param $valueToUpdate
     * @return mixed
     */
    public function updateStudentActiveModel ( $primaryKey, $primaryColumnName, $valueToUpdate );

    #endregion

    #region Reading

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
     * @param int $studentId
     * @param int $subjectId
     * @param string $date
     * @return mixed The is active column value from specific founding row
     */
    public function readStudentActive ( int $studentId, int $subjectId, string $date );

    /**
     * @return mixed List of subjects which student have
     */
    public function readStudentSubjects ();

    #endregion

}
