<?php


namespace App\ApiModels;

//TODO: Add readonly fields depend on sending time - is teacher lesson now or not
class StudentFrequencyResultApiModel extends StudentResultApiModel {

    #region Private Members

    protected static $student;
    protected static $isActive;
    protected static $date;
    protected static $readonly;

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

    /**
     * @return string
     */
    public static function getDate () {
        return self :: $date;
    }

    /**
     * @param string $date
     */
    public static function setDate ( string $date ): void {
        self :: $date = $date;
    }

    /**
     * @return bool
     */
    public static function getReadonly () {
        return self :: $readonly;
    }

    /**
     * @param bool $readonly
     */
    public static function setReadonly ( bool $readonly ): void {
        self :: $readonly = $readonly;
    }

    #endregion

}
