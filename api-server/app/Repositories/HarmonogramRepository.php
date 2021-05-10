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

}
