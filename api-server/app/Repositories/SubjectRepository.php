<?php


namespace App\Repositories;


use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\Auth;

class SubjectRepository implements SubjectRepositoryInterface {

    #region Public Methods

    public function readTeacherSubject () {
        // get login user id
        $userId = Auth::user()->getAuthIdentifier();

        // get teacher id
        $teacherId = Teacher::query()
            ->where('user_id', '=', $userId)
            ->pluck('teacher_id');

        // if founded then
        if ($teacherId->count() != 0) {

            // get all subject ids
            $subjectIds = TeacherSubject ::query()
                -> where( 'teacher_id', '=', $teacherId[ 0 ] )
                -> pluck( 'subject_id' );

            // by subjects ids get subject list
            $subjects = Subject ::query()
                -> whereIn( 'subject_id', $subjectIds )
                -> select( 'name', 'icon' )
                -> get();

            return $subjects;
        }

        return null;
    }

    #endregion

}
