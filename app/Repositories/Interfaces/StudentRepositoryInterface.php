<?php


namespace App\Repositories\Interfaces;


use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Models\StudentStatistics;
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

//    public function storeStudentStatistics (  );

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

    public function updateStudentStatistics ( $primaryKey, $primaryColumnName, $model );

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
    public function readStudentMarksBySubjectAndIdentifier ( string $identifier, string $subjectName );

    /**
     * @param $studentMarkId int The primary key of the student_marks table
     * @return mixed The mark id from marks table for this id
     */
    public function readStudentMarkByStudentMarkId ( int $studentMarkId );

    /**
     * @param string $subjectName
     * @param int $studentId
     * @return mixed
     */
    public function readStudentMarksBySubjectName ( string $subjectName, int $studentId);

    /**
     * @param string $subjectName
     * @param int $studentId
     * @return mixed
     */
    public function readStudentFrequencyBySubjectName ( string $subjectName, int $studentId );

    /**
     * @param int $studentId
     * @param int $subjectId
     * @param string $date
     * @return mixed The is active column value from specific founding row
     */
    public function readStudentActive ( int $studentId, int $subjectId, string $date );

    /**
     * @param int $studentId
     * @param int $subjectId
     * @return mixed Primary key
     */
    public function readStudentStatisticsId ( int $studentId, int $subjectId );

    /**
     * @param int $studentId
     * @param int $subjectId
     * @return StudentStatistics Row
     */
    public function readStudentStatisticsById ( int $studentId, int $subjectId );

    #region Statistics Table

    /**
    * @return float | null The avg marks from student_statistics table
     */
    public function readAvgMarksBySubjectId($studentId, $subjectId);

    /**
     * @return int | null The position of the avg marks from student_statistics table
     */
    public function readAvgMarksPositionBySubjectName ( int $studentId, int $subjectId );

    /**
     * Collect all avgs marks student have to list from student_statistics_table
     */
    public function readListAvgMarks ( int $studentId );

    /**
     * @return float | null The frequency from student_statistics table
     */
    public function readFrequencyBySubjectId($studentId, $subjectId);

    /**
     * @return int | null The position of the frequency from student_statistics table
     */
    public function readFrequencyPositionBySubjectName ( int $studentId, int $subjectId );

    /**
     * Collect all frequencies  student have to list from student_statistics_table
     */
    public function readListFrequency ( int $studentId );

    #endregion

    #endregion

}
