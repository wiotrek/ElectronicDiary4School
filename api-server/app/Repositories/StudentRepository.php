<?php


namespace App\Repositories;


use App\Helpers\KeyColumn;
use App\Models\Mark;
use App\Models\MarksType;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Models\Subject;
use App\Models\SubjectClass;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserClass;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Defuse\Crypto\Key;

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

    public function readStudentMarksBySubjectAndIdentifier( $identifier, $subjectName) {

        $student_id = $this->readStudentIdByIdentifier($identifier);


        $subject_id = $this->findByColumn($subjectName, 'name', Subject::class)->
                             pluck(KeyColumn::fromModel(Subject::class));


        $marks = $this->findByAndColumns($student_id[0], $subject_id,
                                         KeyColumn::fromModel(Student::class), KeyColumn::fromModel(Subject::class), StudentMark::class)->
                        select('student_marks_id', 'marks_id', 'topic', 'marks_type_id')->get();


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

    public function readStudentMarksBySubject ( $subjectName ) {

        // subject if of becoming subject name
        $subjectId = $this->findByColumn($subjectName,  'name', Subject::class)->
        pluck(KeyColumn::fromModel(Subject::class))[0];


        // get list of marks for subject student have
        if (!is_null($subjectId)) {
            $marks = StudentMark ::query() ->
            where( [
                'student_id' => $this -> getStudentId(),
                'subject_id' => $subjectId,
            ] ) -> select( 'marks_id', 'marks_type_id' ) -> get();
        }

        return $marks;
    }

    #endregion
}
