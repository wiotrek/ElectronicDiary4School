<?php


namespace App\WebModels;


/**
 * Class StudentActivityWebModel List of data from request to work on them before specific student is storing to DB
 * @package App\WebModels
 */
class StudentActivityWebModel {

    #region Private Members

    /**
     * @var string The student identifier
     */
    private $studentIdentifier;

    /**
     * @var string The subject name
     */
    private $subjectName;

    /**
     * @var mixed The flag indicated student is present on lesson or not
     */
    private $active;

    /**
     * @var mixed Date with yyyy-MM-dd format
     */
    private $dateActive;

    #endregion

    #region Get / Set

    /**
     * @return mixed
     */
    public function getStudentIdentifier () {
        return $this -> studentIdentifier;
    }

    /**
     * @param mixed $studentIdentifier
     */
    public function setStudentIdentifier ( $studentIdentifier ): void {
        $this -> studentIdentifier = $studentIdentifier;
    }

    /**
     * @return mixed
     */
    public function getSubjectName () {
        return $this -> subjectName;
    }

    /**
     * @param mixed $subjectName
     */
    public function setSubjectName ( $subjectName ): void {
        $this -> subjectName = $subjectName;
    }

    /**
     * @return mixed
     */
    public function getActive () {
        return $this -> active;
    }

    /**
     * @param mixed $active
     */
    public function setActive ( $active ): void {
        $this -> active = $active;
    }

    /**
     * @return mixed
     */
    public function getDateActive () {
        return $this -> dateActive;
    }

    /**
     * @param mixed $dateActive
     */
    public function setDateActive ( $dateActive ): void {
        $this -> dateActive = $dateActive;
    }

    #endregion

}
