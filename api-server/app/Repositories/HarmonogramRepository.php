<?php


namespace App\Repositories;


use App\Helpers\KeyColumn;
use App\Models\ClassHarmonogram;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\UserClass;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\HarmonogramRepositoryInterface;

class HarmonogramRepository extends BaseRepository implements HarmonogramRepositoryInterface {

    public function isExistLesson ( int $classId, int $subjectId, string $day, string $startTime ) {
        $primaryKey = ClassHarmonogram::query()->where([
            [KeyColumn::fromModel(UserClass::class), '=', $classId],
            [KeyColumn::fromModel(Subject::class), '=', $subjectId],
            [KeyColumn::fromModel(Teacher::class), '=', $this->getTeacherId()[0]],
            ['date_meeting', '=', $day],
            ['start_time', '=', $startTime]
        ])->pluck(KeyColumn::fromModel(ClassHarmonogram::class));

        if ($primaryKey->count() == 0)
            return 0;

        return $primaryKey[0];
    }

    public function readTeachersWhichHaveLessonNow ($day, $time) {
        return ClassHarmonogram::query()->where([
            'date_meeting' => $day,
            'start_time' => $time
        ])->select('teacher_id', 'subject_id', 'user_class_id')->orderBy('teacher_id')->get();
    }

    public function readTeacherListWhichClassTeach ( int $userClassId ) {
        $teacherList = ClassHarmonogram::query()->
            leftjoin('teacher', 'class_harmonogram.teacher_id', '=', 'teacher.teacher_id')->
            leftjoin('user', 'teacher.user_id', '=', 'user.user_id')->
            leftjoin('subject', 'class_harmonogram.subject_id', '=', 'subject.subject_id')->
            where('class_harmonogram.user_class_id', '=', $userClassId)->
            select('user.first_name', 'user.identifier', 'user.last_name', 'user.identifier', 'subject.name')->
            distinct('user.identifier')->
            get();

        return $teacherList;
    }


}
