<?php


namespace App\ApiModels\Marks;


/**
 * The list-data of all students with their marks
 */
class MarksListViewResultApiModel  {

    #region List Item Object

    protected $StudentMark;

    #endregion

    #region Accessors

    /**
     * @return mixed
     */
    public function getStudentMark () {
        return $this->StudentMark;
    }

    /**
     * @param MarksItemViewResultApiModel $StudentMark
     */
    public function setStudentMark ( MarksItemViewResultApiModel $StudentMark ): void {
        $this->StudentMark[] = array(
            'student' => $StudentMark->getStudent(),
            'marks' => $StudentMark->getMarks()
        );
    }

    #endregion

}
