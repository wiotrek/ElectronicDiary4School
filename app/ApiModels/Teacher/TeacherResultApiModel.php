<?php


namespace App\ApiModels\Teacher;


class TeacherResultApiModel {

    #region Private Members

    private $identifier;
    private $firstName;
    private $lastName;

    /**
     * @var string subject name which is teaching by this teacher
     */
    private $subjectName;

    #endregion

    #region Accessors

    /**
     * @return string
     */
    public function getIdentifier () {
        return $this -> identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier ( string $identifier ): void {
        $this -> identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getFirstName () {
        return $this -> firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName ( string $firstName ): void {
        $this -> firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName () {
        return $this -> lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName ( string $lastName ): void {
        $this -> lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getSubjectName () {
        return $this -> subjectName;
    }

    /**
     * @param string $subjectName
     */
    public function setSubjectName ( string $subjectName ): void {
        $this -> subjectName = $subjectName;
    }

    #endregion

}
