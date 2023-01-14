<?php


namespace App\DataModels;

use ReflectionClass;

/**
 * Class IconClass List of defined class icons from font-awesome
 * @package App\DataModels
 */
class IconClass {

    #region Const Members

    const CLUB = 'bi bi-suit-club';
    const CLUB_FILL = 'bi bi-suit-club-fill';
    const DIAMOND = 'bi bi-suit-diamond';
    const DIAMOND_FILL = 'bi bi-suit-diamond-fill';
    const HEART = 'bi bi-suit-heart';
    const HEART_FILL = 'bi bi-suit-heart-fill';
    const SPADE = 'bi bi-suit-spade';
    const SPADE_FILL = 'bi bi-suit-spade-fill';

    #endregion

    /**
     * @return array Return list of all const values defined at @param IconClass
     */
    static function getConstants(): array {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

}
