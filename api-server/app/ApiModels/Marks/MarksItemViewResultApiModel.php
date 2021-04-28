<?php


namespace App\ApiModels;


use App\ApiModels\Base\ApiModel;
use App\ApiModels\Marks\Design\MarkListItem;

/**
 * The data-list of marks for a single student
 */
class MarksItemViewResultApiModel extends ApiModel {

    #region Protected Static Properties

    /**
     * Basic details about student
     */
    protected static $student;

    /**
     * The list of the student marks
     */
    protected static $mark;

    #endregion

    #region Accessors

    /**
     * @return mixed
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
     * @return mixed
     */
    public static function getMark () {
        return self :: $mark;
    }

    /**
     * @param MarkListItem $mark
     */
    public static function setMark ( MarkListItem $mark ): void {
        self :: $mark = $mark;
    }

    #endregion

    public function __toString () {
        return self :: toString();
    }

}
