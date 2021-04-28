<?php


namespace App\ApiModels;

use App\ApiModels\Base\ApiModel;

/**
 * Class StudentResultApiModel The result of student details via API
 * @package App\ApiModels\
 */
class StudentResultApiModel extends ApiModel {

    #region Private Members

    protected static $identifier;
    protected static $first_name;
    protected static $last_name;

    #endregion

    #region Get / Set

    /**
     * @return string
     */
    public static function getIdentifier () {
        return self :: $identifier;
    }

    /**
     * @param string $identifier
     */
    public static function setIdentifier ( string $identifier ): void {
        self :: $identifier = $identifier;
    }

    /**
     * @return string
     */
    public static function getFirstName () {
        return self :: $first_name;
    }

    /**
     * @param string $first_name
     */
    public static function setFirstName ( string $first_name ): void {
        self :: $first_name = $first_name;
    }

    /**
     * @return string
     */
    public static function getLastName () {
        return self :: $last_name;
    }

    /**
     * @param string $last_name
     */
    public static function setLastName ( string $last_name ): void {
        self :: $last_name = $last_name;
    }

    #endregion

}
