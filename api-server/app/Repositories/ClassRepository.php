<?php


namespace App\Repositories;

use App\Helpers\KeyColumn;

use App\Models\Teacher;
use App\Models\TeacherClass;
use App\Models\UserClass;
use App\Repositories\Base\BaseRepository;

class ClassRepository extends BaseRepository implements ClassRepositoryInterface {

    #region Public Methods

    public function readTeacherClasses () {

        // get teacher id
        $teacherId = $this->getTeacherId();

        // if founded then
        if ($teacherId->count() != 0) {

            // get all classes ids
            $classesIds = $this->findIdByOtherId($teacherId[0],
                KeyColumn::name(Teacher::class),
                KeyColumn::name(UserClass::class),
                TeacherClass::class);

            // by classes ids get objects of the classes list
            return UserClass::query()
                -> whereIn( 'user_class_id', $classesIds )
                -> selectRaw( 'CONCAT(number, identifier_number) as klasa' )
                -> get();
        }
    }

    #endregion
}
