<?php


namespace App\ApiModels\Subject;


class SubjectDetailsApiModel extends SubjectApiModel {

    #region Private Members

    /**
     * @var double Average marks as end mark for specific subject
     */
    private $marksAverage;

    /**
     * @var float The position indicate on which place student average marks is for specific subject
     */
    private $position;

    #endregion

    #region Accessors

    /**
     * @return float | null
     */
    public function getMarksAverage () {
        return $this -> marksAverage;
    }

    /**
     * @param float | null $marksAverage
     */
    public function setMarksAverage ( ?float $marksAverage ): void {
        $this -> marksAverage = $marksAverage;
    }

    /**
     * @return int | null
     */
    public function getPosition () {
        return $this -> position;
    }

    /**
     * @param int | null $position
     */
    public function setPosition ( ?int $position ): void {
        $this -> position = $position;
    }

    #endregion

}
