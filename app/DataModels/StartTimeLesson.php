<?php


namespace App\DataModels;


use ReflectionClass;

class StartTimeLesson {

    public const FIRST = '08:00';
    public const SECOND = '08:55';
    public const THIRD = '09:45';
    public const FOURTH = '10:35';
    public const FIFTH = '11:40';
    public const SIXTH = '12:45';
    public const SEVENTH = '13:35';
    public const EIGHTH = '14:25';

    public function getConstants (  ) {
        // Get detail information about this class (DayTranslate)
        $oClass = new ReflectionClass(__CLASS__);
        // return constants of this class
        return $oClass->getConstants();
    }

}
