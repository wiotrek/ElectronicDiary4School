<?php


namespace App\ApiModels\Marks;


use App\ApiModels\Base\ApiModel;
use App\ApiModels\Marks\Design\MarkListItem;
use App\ApiModels\StudentResultApiModel;

/**
 * The data-list of marks for a single student
 */
class MarksItemViewResultApiModel {

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
     * @return MarkListItem
     */
    public static function getMark () {
        return self :: $mark;
    }

    /**
     * @param MarkListItem $mark
     */
    public static function setMark ( MarkListItem $mark ): void {
        self :: $mark = array(
            'marks' => $mark->getMarks()
        );
    }

    #endregion

}
