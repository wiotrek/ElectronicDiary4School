<?php


namespace App\Helpers;


use ReflectionClass;

class DayTranslate {

    #region Constants

    public const MONDAY = 'Poniedziałek';
    public const TUESDAY = 'Wtorek';
    public const WEDNESDAY = 'Środa';
    public const THURSDAY = 'Czwartek';
    public const FRIDAY = 'Piątek';
    public const SATURDAY = 'Sobota';
    public const SUNDAY = 'Niedziela';

    #endregion

    #region Public Methods

    /**
     * Translate day names from english to polish
    **/
    public function fromEngToPl ( string $engDay ) {

        // Get detail information about this class (DayTranslate)
        $oClass = new ReflectionClass(__CLASS__);
        // Get constants of this class
        $constants = $oClass->getConstants();

        foreach ( $constants as $name => $value ) {
            if ($name === strtoupper($engDay))
                return $value;
        }

        return null;
    }

    #endregion

}
