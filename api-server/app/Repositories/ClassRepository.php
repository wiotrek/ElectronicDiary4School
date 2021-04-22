<?php


namespace App\Repositories;


use App\Models\ClassHarmonogram;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use App\Models\UserClass;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\ClassRepositoryInterface;

class ClassRepository extends BaseRepository implements ClassRepositoryInterface {

    #region Public Methods

    public function readTeacherClasses ( string $subjectName) {

        // get teacher id
        $teacherId = $this->getTeacherId();

        // if founded then
        if ($teacherId->count() != 0) {

            // Get subject id by arriving subject name from client
            $subjectId = $this->findByColumn(
                $subjectName,
                'name',
                Subject::class)->pluck('subject_id');

            // get all classes ids
            $classesIds = $this->findByAndColumns(
                $teacherId[0],
                $subjectId,
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

        return null;
    }

    public function readStudentsByIdentifier ( string $identifier ) {
        $userId = $this->findByColumn($identifier, 'identifier', User::class)
            ->pluck('user_id');

        $userClassId = $this->findByColumn($userId, 'user_id', Student::class)
            ->pluck('user_class_id');

        $students = $this->findByColumn($userClassId, 'user_class_id', Student::class)
            ->pluck('student_id');

        return ($students);
    }

    public function readStudentsByClass ( $class ) {
        // TODO: Implement readStudentsByClass() method.
    }

    #endregion

}
