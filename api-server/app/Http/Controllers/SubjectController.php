<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function getTeacherSubject ( Request $request ) {

        $teacher = Auth::user();


        return $teacher->getAuthIdentifier();
    }

    public function findSubject ( $teacherId ) {
        $teacher_id = Teacher::query()->where('teacher_id', '=', $teacherId)->select('user_id')->get();

        return $teacher_id;
    }
}
