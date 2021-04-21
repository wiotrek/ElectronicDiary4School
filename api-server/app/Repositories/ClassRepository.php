<?php


namespace App\Repositories;


use App\Models\ClassHarmonogram;
use App\Models\UserClass;
use App\Repositories\Base\BaseRepository;

class ClassRepository extends BaseRepository implements ClassRepositoryInterface {

    #region Public Methods

    public function readTeacherClasses ($subject_id) {

        // get teacher id
        $teacherId = $this->getTeacherId();

        // if founded then
        if ($teacherId->count() != 0) {

            // get all classes ids
            $classesIds = $this->findByAndColumns(
                $teacherId[0],
                $subject_id,
                'teacher_id',
                'subject_id',
                ClassHarmonogram::class)
                ->pluck('user_class_id');


            // by classes ids get objects of the classes list
            return UserClass::query()
                -> whereIn( 'user_class_id', $classesIds )
                -> selectRaw( 'CONCAT(number, identifier_number) as klasa' )
                -> get();
        }
    }

    #endregion
}
