<?php


namespace App\Icons;


use App\DataModels\IconClass;

/**
 * Class IconGenerator Generate random icon
 * @package App\Icons
 */
class IconGenerator {

    public static function getClassIcon() {
        $classIconList = IconClass::getConstants();

        $randomIndex = rand(0, count($classIconList) - 1);

        return array_values($classIconList)[$randomIndex];
    }

}
