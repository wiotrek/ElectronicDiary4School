<?php


namespace App\Services;

use App\Models\Student;
use App\Models\User;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use App\Repositories\StudentRepository;

class ClassService {

    #region Private Members

    private $classRepository;
    private $studentRepository;
    private $subjectRepository;

    #endregion

    #region DI Constructor

    public function __construct (ClassRepositoryInterface $classRepository,
                                                       StudentRepositoryInterface $studentRepository,
                                                       SubjectRepositoryInterface $subjectRepository) {

        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
        $this -> subjectRepository = $subjectRepository;
    }

    #endregion

    #region Public Methods

    /**
     * @param $subjectName string Get classes which teacher have this subject
     * @return mixed|null
     */
    public function getTeacherClasses ( string $subjectName ) {

        if (!$this->subjectRepository->isSubjectExistBySubjectName($subjectName))
            return null;


        $teachersClasses = $this->classRepository->readTeacherClasses($subjectName);

        if (is_null($teachersClasses))
            return null;


        return $teachersClasses;
    }

    /**
     * @param null $identifier The user identifier
     * @param null $class The class contain number identifier and number like "5b"
     * @return mixed All ids of students from specific class
     */
    public function getStudentsIdFromClass($identifier = null, $class = null){

        if ($class != null)
            $studentList = $this->classRepository->readStudentsByClass($class);

        if($identifier != null)
            $studentList = $this->classRepository->readStudentsByIdentifier($identifier);

        return $studentList;
    }

    /**
     * @param $studentIdentifiers mixed list of active student identifiers
     * @return array All ids of active students
     */
    public function getIdsOfActiveStudents($studentIdentifiers): array {
        $studentIds = [];

        foreach ( $studentIdentifiers as $studentIdentifier ) {
            $userId = $this->classRepository
                ->findByColumn($studentIdentifier, 'identifier', User::class)
                ->pluck('user_id');

            $studentId = $this->classRepository
                ->findIdByOtherId($userId, 'user_id', 'student_id', Student::class);

            $studentIds[] = $studentId;
        }

        return $studentIds;
    }

    /**
     * @param $number
     * @param $numberIdentifier
     * @return mixed All students from class with details - identifier, first_name, last_name
     */
    public function getStudentListByClass ( $number, $numberIdentifier ) {
        return $this->classRepository->readStudentsByClass($number, $numberIdentifier);
    }

    public function getClassIdByIdentifier($identifier) {
        return $this->classRepository->readClassIdByStudentIdentifier($identifier);
    }

    public function getStudentIdByIdentifier ( $identifier ) {
        return $this->studentRepository->readStudentIdByIdentifier($identifier);
    }

    public function getClassIdByClassName ( $number, $identifier ) {
        return $this->classRepository->readClassIdByIdentifierAndNumber($number, $identifier);
    }

    #endregion

}
