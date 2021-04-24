<?php


namespace App\ApiModels;

/**
 * Class StudentResultApiModel The result of student details via API
 * @package App\ApiModels\
 */
class StudentResultApiModel {

    #region Private Members

    private $identifier;
    private $firstName;
    private $lastName;

    #endregion

    #region Get / Set

    /**
     * @return mixed
     */
    public function getIdentifier () {
        return $this -> identifier;
    }

    /**
     * @param mixed $identifier
     */
    public function setIdentifier ( $identifier ): void {
        $this -> identifier = $identifier;
    }

    /**
     * @return mixed
     */
    public function getFirstName () {
        return $this -> firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName ( $firstName ): void {
        $this -> firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName () {
        return $this -> lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName ( $lastName ): void {
        $this -> lastName = $lastName;
    }

    #endregion

}
