<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function getTeacherSubject () {

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

            // by subjects ids get list subject names
            $subjects = Subject ::query()
                -> whereIn( 'subject_id', $subjectIds )
                -> pluck( 'name' );

            return $subjects;
        }

        // null if teacher id not founded
        return null;
    }
}
