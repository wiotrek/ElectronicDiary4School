<?php


namespace App\ApiModels\Frequency;

use App\ApiModels\StudentResultApiModel;

class StudentFrequencyResultApiModel extends StudentResultApiModel {

    #region Private Members

    /**
     * @var StudentResultApiModel The specific student with details
     */
    protected static $student;

    /**
     * @var bool The flag indicates that student was active or not
     */
    protected static $isActive;

    #endregion

    #region Accessors

    /**
     * @return StudentResultApiModel
     */
    public static function getStudent () {
        return self :: $student;
    }

    /**
     * @param StudentResultApiModel $student
     */
    public static function setStudent ( StudentResultApiModel $student ): void {
        self :: $student = array(
            'first_name' => $student->getFirstName(),
            'last_name' => $student->getLastName(),
            'identifier' => $student->getIdentifier()
        );
    }

    /**
     * @return boolean
     */
    public static function getIsActive () {
        return self :: $isActive;
    }

    /**
     * @param bool $isActive
     */
    public static function setIsActive ( bool $isActive ): void {
        self :: $isActive = $isActive;
    }

    #endregion

}
