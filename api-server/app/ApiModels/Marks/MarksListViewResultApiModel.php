<?php


namespace App\ApiModels\Marks;


use App\ApiModels\Base\ApiModel;
use App\ApiModels\MarksItemViewResultApiModel;

/**
 * The list-data of all students with their marks
 */
class MarksListViewResultApiModel extends ApiModel {

    #region List Item Object

    protected static $StudentMark;

    #endregion

    #region Accessors

    /**
     * @return mixed
     */
    public static function getStudentMark () {
        return self :: $StudentMark;
    }

    /**
     * @param MarksItemViewResultApiModel $StudentMark
     */
    public static function setStudentMark ( MarksItemViewResultApiModel $StudentMark ): void {
        self :: $StudentMark = $StudentMark;
    }

    #endregion

    public function __toString () {
        return self :: toString();
    }

}
