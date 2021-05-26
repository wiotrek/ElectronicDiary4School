<?php


namespace App\Repositories;


use App\Helpers\KeyColumn;

use App\Helpers\RoleDetecter;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SubjectClass;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface {

    #region Public Methods

    public function readTeacherSubject () {
        // get login user id
        $userId = Auth::user()->getAuthIdentifier();

        // get teacher id
        $teacherId = $this->findIdByOtherId(
            $userId,
            KeyColumn::fromModel(User::class),
            KeyColumn::fromModel(Teacher::class),
            Teacher::class);

        // if founded then
        if ($teacherId->count() != 0) {

            // get all subject ids
            $subjectIds = $this->findIdByOtherId($teacherId[0],
                KeyColumn::fromModel(Teacher::class),
                KeyColumn::fromModel(Subject::class),
                TeacherSubject::class);

            // by subjects ids get subject list
            return Subject ::query()
                -> whereIn( 'subject_id', $subjectIds )
                -> select( 'name', 'icon' )
                -> get();
        }

        return null;
    }

    public function readStudentSubjects () {

        $userClassId = $this->findIdByOtherId(RoleDetecter::convertToStudentId(), 'student_id', 'user_class_id', Student::class)->first();
        $subjectClassIds = $this->findIdByOtherId($userClassId, 'user_class_id', 'subject_id', SubjectClass::class);

        return Subject ::query()
            -> whereIn( 'subject_id', $subjectClassIds )
            -> select( 'name', 'icon' )
            -> get();
    }

    public function readSubjectIdByName ( $subjectName ) {
        return $this->findByColumn($subjectName, 'name', Subject::class)
            ->pluck('subject_id');
    }

    public function readSubjectNameById ( $subjectId ) {
        return $this->findByColumn($subjectId, KeyColumn::fromModel(Subject::class), Subject::class)
            ->pluck('name');
    }

    #endregion

}
