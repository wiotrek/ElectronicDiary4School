<?php


namespace App\Repositories;


use App\Helpers\KeyColumn;
use App\Helpers\RoleDetecter;
use App\Models\Mark;
use App\Models\MarksType;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Models\StudentStatistics;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\StudentRepositoryInterface;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface {

    #region Saving

    public function saveStudentActivity ( StudentActivity $activity ) {
        $activity -> save();
    }

    public function storeStudentMark ( StudentMark $studentMarkEloquent ) {
        $studentMarkEloquent -> save();
    }

    #endregion

    #region Updating

    public function updateStudentMarkModel ( $primaryKey, $primaryColumnName, $valueToUpdate ) {
        return $this->updateModel($primaryKey, $primaryColumnName, StudentMark::class)->
        update(['marks_id' => $valueToUpdate]);
    }

    public function updateStudentActiveModel ( $primaryKey, $primaryColumnName, $valueToUpdate ) {
        return $this->updateModel($primaryKey, $primaryColumnName, StudentActivity::class)->
        update([
            'active' => $valueToUpdate,
            'checked' => 1
        ]);
    }

    public function updateStudentStatistics ( $primaryKey, $primaryColumnName, $model ) {
        $this->updateModel($primaryKey, $primaryColumnName, $model)->
        update([
            'average_marks' => $model->average_marks,
            'average_position' => $model->average_position,
            'frequency' => $model->frequency,
            'frequency_position' => $model->frequency_position
        ]);
    }

    #endregion

    #region Reading

    public function readStudentIdByIdentifier($identifier) {

        $user_id = $this->findByColumn($identifier, 'identifier', User::class)
        ->pluck(KeyColumn::fromModel(User::class));

        return $this->findIdByOtherId($user_id, KeyColumn::fromModel(User::class), KeyColumn::fromModel(Student::class), Student::class);
    }

    public function readStudentActiveIdByStudentIdAndDate ( $studentId, $date, $time ) {
        return StudentActivity::query()->
        where([
            'student_id' => $studentId,
            'date_active' => $date,
            'time_active' => $time
        ])->
        pluck(KeyColumn::fromModel(StudentActivity::class));
    }

    public function readSubjectIdByStudentActiveId ( $studentActiveId ) {
        return $this->findByColumn($studentActiveId, KeyColumn::fromModel(StudentActivity::class), StudentActivity::class)->
            pluck(KeyColumn::fromModel(Subject::class));
    }

    public function readStudentMarksBySubjectAndIdentifier( $identifier, $subjectName) {

        $student_id = $this->readStudentIdByIdentifier($identifier);


        $subject_id = $this->findByColumn($subjectName, 'name', Subject::class)->
                             pluck(KeyColumn::fromModel(Subject::class));


        $marks = $this->findByAndColumns($student_id[0], $subject_id,
                                         KeyColumn::fromModel(Student::class), KeyColumn::fromModel(Subject::class), StudentMark::class)->
                        select('student_marks_id', 'marks_id', 'topic', 'marks_type_id')->get();


        // TODO: Move to service
        if (count($marks) === 0)
            return null;


        foreach ( $marks as $mark ) {

            $student_mark_id = $mark['student_marks_id'];
            $markValue = $this->findByColumn($mark['marks_id'], 'marks_id', Mark::class)->pluck('degree');
            $topic = $mark['topic'];
            $markType = $this->findByColumn($mark['marks_type_id'], 'marks_type_id', MarksType::class)->pluck('mark_from');

            $markList[] = array(
                'student_marks_id' => $student_mark_id,
                'mark' => $markValue[0],
                'topic' => $topic,
                'kindOf' => $markType[0]
            );

        }

        return $markList;
    }

    public function readStudentMarkByStudentMarkId ( $studentMarkId ) {
        $markId =  $this->findByColumn($studentMarkId, 'student_marks_id', StudentMark::class)
            ->pluck('marks_id');

        return $this->findByColumn($markId, 'marks_id', Mark::class)
            -> pluck('degree');
    }

    public function readStudentActive ( int $studentId, int $subjectId, string $date ) {
        $teacherId = $this->getTeacherId()[0];

        return StudentActivity::query()->
            where([
                KeyColumn::fromModel(Student::class) => $studentId,
                KeyColumn::fromModel(Teacher::class) => $teacherId,
                KeyColumn::fromModel(Subject::class) => $subjectId,
                'date_active' => $date
        ])->pluck('active')->first();
    }

    public function readStudentMarksBySubjectName ( $subjectName, $studentId ) {

        // subject id of becoming subject name
        $subjectId = $this->findByColumn($subjectName,  'name', Subject::class)->
        pluck(KeyColumn::fromModel(Subject::class))[0];

        // get list of marks for subject student have
        if (!is_null($subjectId)) {
            $marks = StudentMark ::query() ->
            where( [
                'student_id' => $studentId,
                'subject_id' => $subjectId,
            ] ) -> select( 'marks_id', 'marks_type_id', 'topic', 'passing_date' ) -> get();
        }

        return $marks;
    }

    public function readStudentFrequencyBySubjectName ( string $subjectName, $studentId ){

        // subject id of becoming subject name
        $subjectId = $this->findByColumn($subjectName,  'name', Subject::class)->
        pluck(KeyColumn::fromModel(Subject::class))[0];

        // get list of frequency for subject student have
        if (!is_null($subjectId)) {
            $frequency = StudentActivity ::query() ->
            where( [
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'checked' => 1
            ] ) -> select( 'active', 'date_active' ) -> orderByDesc('date_active') -> get();
        }

        return $frequency;
    }

    public function readStudentStatisticsId ( int $studentId, int $subjectId ) {
        return $this->findByAndColumns($studentId, $subjectId,
            KeyColumn::fromModel(Student::class), KeyColumn::fromModel(Subject::class),
            StudentStatistics::class)->
            pluck(KeyColumn::fromModel(StudentStatistics::class));
    }

    public function readStudentStatisticsById ( int $studentId, int $subjectId ) {
        return $this->findByAndColumns($studentId, $subjectId,
            KeyColumn::fromModel(Student::class), KeyColumn::fromModel(Subject::class),
            StudentStatistics::class)->
        first();
    }

    public function readAvgMarksBySubjectId($studentId, $subjectId) {

        return $this->findByAndColumns($studentId, $subjectId,
            KeyColumn::fromModel(Student::class), KeyColumn::fromModel(Subject::class),
            StudentStatistics::class)->
        pluck('average_marks');
    }

    public function readAvgMarksPositionBySubjectName ( int $studentId, int $subjectId ) {

        return $this->findByAndColumns($studentId, $subjectId,
            KeyColumn::fromModel(Student::class), KeyColumn::fromModel(Subject::class),
            StudentStatistics::class)->
            whereNotNull('average_position') ->
            pluck('average_position');
    }

    public function readListAvgMarks ( int $studentId ) {

        return $this->findByColumn($studentId, KeyColumn::fromModel(Student::class), StudentStatistics::class)->
            whereNotNull('average_marks') ->
            pluck('average_marks');
    }

    public function readFrequencyBySubjectId($studentId, $subjectId) {
        return $this->findByAndColumns($studentId, $subjectId,
            KeyColumn::fromModel(Student::class), KeyColumn::fromModel(Subject::class),
            StudentStatistics::class)->
            whereNotNull('frequency')->
            pluck('frequency');
    }

    public function readFrequencyPositionBySubjectName ( int $studentId, int $subjectId ) {
        return $this->findByAndColumns($studentId, $subjectId,
            KeyColumn::fromModel(Student::class), KeyColumn::fromModel(Subject::class),
            StudentStatistics::class)->
        whereNotNull('frequency_position')->
        pluck('frequency_position');
    }

    public function readListFrequency ( int $studentId ) {
        return $this->findByColumn($studentId, KeyColumn::fromModel(Student::class), StudentStatistics::class)->
        whereNotNull('frequency')->
        pluck('frequency');
    }

    #endregion
}
