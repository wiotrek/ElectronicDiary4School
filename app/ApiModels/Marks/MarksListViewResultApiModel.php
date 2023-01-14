<?php


namespace App\ApiModels\Marks;


use App\Serialization\JsonBuilder\Parts\JsonObject;

/**
 * The list-data of all students with their marks
 */
class MarksListViewResultApiModel extends JsonObject {

    #region List Item Object

    protected $StudentMark;

    #endregion

    #region Accessors

    /**
     * @return MarksItemViewResultApiModel
     */
    public function getStudentMark () {
        return $this->StudentMark;
    }

    /**
     * @param MarksItemViewResultApiModel $StudentMark
     */
    public function setStudentMark ( MarksItemViewResultApiModel $StudentMark ): void {
        $this->StudentMark[] = //$StudentMark->createJsonObject();
            array(
            'student' => $StudentMark->getStudent(),
            'marks' => $StudentMark->getMarks()
        );
    }

    #endregion

    public function __toString () {
        return self :: createJsonObject();
    }

}
