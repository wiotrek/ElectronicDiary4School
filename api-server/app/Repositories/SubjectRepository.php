<?php


namespace App\Repositories;


use App\Helpers\KeyColumn;

use App\Models\Subject;
use App\Models\SubjectClass;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Auth;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface {

    #region Public Methods

    public function readTeacherSubject () {
        // get login user id
        $userId = Auth::user()->getAuthIdentifier();

        // get teacher id
        $teacherId = $this->findIdByOtherId(
            $userId,
            KeyColumn::name(User::class),
            KeyColumn::name(Teacher::class),
            Teacher::class);

        // if founded then
        if ($teacherId->count() != 0) {

            // get all subject ids
            $subjectIds = $this->findIdByOtherId($teacherId[0],
                KeyColumn::name(Teacher::class),
                KeyColumn::name(Subject::class),
                TeacherSubject::class);

            // by subjects ids get subject list
            $subjects = Subject ::query()
                -> whereIn( 'subject_id', $subjectIds )
                -> select( 'name', 'icon' )
                -> get();

            return $subjects;
        }

        return null;
    }

    // TODO For test - delete later
    public function readAll () {

//        return $this->findById(80, SubjectClass::class);
        return $this->all(SubjectClass::class);
    }

    #endregion


}
