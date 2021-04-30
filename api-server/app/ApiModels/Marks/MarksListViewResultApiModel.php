<?php


namespace App\ApiModels\Marks;


use App\ApiModels\Base\ApiModel;

/**
 * The list-data of all students with their marks
 */
class MarksListViewResultApiModel  {

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
        self :: $StudentMark[] = array(
            $StudentMark->getStudent(),
            $StudentMark->getMark()
        );
    }

    #endregion

//    public function __toString () {
//        return self :: toString();
//    }

}
