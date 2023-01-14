<?php


namespace App\Services;


use App\Helpers\KeyColumn;
use App\Helpers\RoleDetecter;
use App\Models\User;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\HarmonogramRepositoryInterface;

class ParentService {

    #region Private Members

    private $classRepository;
    private $harmonogramRepository;

    #endregion

    #region DI Constructor

    /**
     * ParentService constructor.
     */
    public function __construct (ClassRepositoryInterface $classRepository,
                                                       HarmonogramRepositoryInterface $harmonogramRepository) {
        $this -> classRepository = $classRepository;
        $this -> harmonogramRepository = $harmonogramRepository;
    }

    #endregion

    #region Public Methods

    /**
     * @return mixed The list of all teachers which are teaching specify student class
     */
    public function getTeacherListOfStudent () {
        $usertId = RoleDetecter::convertParentIdToStudentUserId();

        $studentIdentifier = $this->classRepository->findByColumn($usertId, KeyColumn::fromModel(User::class), User::class)->
            pluck('identifier')[0];

        $studentClassId = $this->classRepository->readClassIdByStudentIdentifier($studentIdentifier)[0];

        return $this->harmonogramRepository->readTeacherListWhichClassTeach($studentClassId);

    }

    #endregion

}
