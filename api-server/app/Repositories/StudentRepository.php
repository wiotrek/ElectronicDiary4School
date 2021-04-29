<?php


namespace App\Repositories;


use App\Helpers\KeyColumn;
use App\Models\Mark;
use App\Models\MarksType;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\StudentMark;
use App\Models\Subject;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\StudentRepositoryInterface;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface {

    public function saveStudentActivity ( StudentActivity $activity ) {
        $activity -> save();
    }

    public function readStudentIdByIdentifier($identifier) {


        $user_id = $this->findByColumn($identifier, 'identifier', User::class)
        ->pluck(KeyColumn::fromModel(User::class));

        return $this->findIdByOtherId($user_id, KeyColumn::fromModel(User::class), KeyColumn::fromModel(Student::class), Student::class);
    }

    public function readStudentMarksBySubject( $identifier, $subjectName) {

        $student_id = $this->readStudentIdByIdentifier($identifier);


        $subject_id = $this->findByColumn($subjectName, 'name', Subject::class)->
                             pluck(KeyColumn::fromModel(Subject::class));


        $marks = $this->findByAndColumns($student_id[0], $subject_id,
                                         KeyColumn::fromModel(Student::class), KeyColumn::fromModel(Subject::class), StudentMark::class)->
                        select('marks_id', 'topic', 'marks_type_id')->get();


        if (count($marks) === 0)
            return null;


        foreach ( $marks as $mark ) {

            $markValue = $this->findByColumn($mark['marks_id'], 'marks_id', Mark::class)->pluck('degree');
            $topic = $mark['topic'];
            $markType = $this->findByColumn($mark['marks_type_id'], 'marks_type_id', MarksType::class)->pluck('mark_from');

            $markList[] = array(
                'mark' => $markValue[0],
                'topic' => $topic,
                'kindOf' => $markType[0]
            );

        }

        return $markList;
    }

}
