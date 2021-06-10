<?php

namespace App\Listeners;

use App\Events\StudentClassIdEvent;
use App\Models\Student;
use App\Models\User;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;

class StudentClassIdListener
{
    /**
     * @var StudentRepositoryInterface
     */
    private $studentRepository;
    /**
     * @var ClassRepositoryInterface
     */
    private $classRepository;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(StudentRepositoryInterface $studentRepository,
                                                      ClassRepositoryInterface $classRepository)
    {
        $this -> studentRepository = $studentRepository;
        $this -> classRepository = $classRepository;
    }

    /**
     * Handle the event.
     *
     * @param StudentClassIdEvent $event
     * @return void
     */
    public function handle( StudentClassIdEvent $event)
    {
        // get class id in which login student is
        $userId = $this->studentRepository->
        findByColumn($event -> studentId, 'student_id', Student::class)->
        pluck('user_id')[0];

        $studentIdentifier = $this->studentRepository->
        findByColumn($userId, 'user_id', User::class)->
        pluck('identifier')[0];

        return $this->classRepository->readClassIdByStudentIdentifier($studentIdentifier);
    }
}
