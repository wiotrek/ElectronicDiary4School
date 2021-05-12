<?php


namespace App\ApiModels;


class StudentFrequencyResultApiModel extends StudentResultApiModel {

    #region Private Members

    protected static $student;
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
        self :: $student = $student;
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
