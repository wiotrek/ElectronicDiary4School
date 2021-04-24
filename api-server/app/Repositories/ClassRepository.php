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

    public function readStudentsByClass ( $number, $numberIdentifier ) {

        // Get class id by data from request
        $class_id = $this->findByAndColumns(
            $number,
            $numberIdentifier,
            'number',
            'identifier_number',
            UserClass::class
        )->pluck('user_class_id');


        // Get user ids of students from this class
        $userIdsOfStdents = $this->
                            findByColumn($class_id, 'user_class_id', Student::class)->
                            pluck('user_id');


        // For each user id get details
        $students = $this->
                    findByMultipleValues($userIdsOfStdents, 'user_id', User::class)->
                    select('identifier', 'first_name', 'last_name')->
                    get();

        return $students;
    }

    #endregion

}
