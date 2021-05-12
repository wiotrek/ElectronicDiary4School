<?php


namespace App\WebModels;


/**
 * Class StudentActivityWebModel List of data from request to work on them before specific student is storing to DB
 * @package App\WebModels
 */
class StudentFrequencyWebModel {

    #region Private Members

    /**
     * @var string The student identifier
     */
    private $studentIdentifier;

    /**
     * @var mixed The flag indicated student is present on lesson or not
     */
    private $active;

    #endregion

    #region Accessors

    /**
     * @return string
     */
    public function getStudentIdentifier () {
        return $this -> studentIdentifier;
    }

    /**
     * @param string $studentIdentifier
     */
    public function setStudentIdentifier ( string $studentIdentifier ): void {
        $this -> studentIdentifier = $studentIdentifier;
    }

    /**
     * @return bool
     */
    public function getActive () {
        return $this -> active;
    }

    /**
     * @param bool $active
     */
    public function setActive ( bool $active ): void {
        $this -> active = $active;
    }

    #endregion

}
