<?php


namespace App\ApiModels\Subject;

/**
 * Class SubjectDetailsApiModel Contain information about student marks and frequency for this subject
 */
class SubjectDetailsApiModel extends SubjectApiModel {

    #region Private Members

    /**
     * @var double Average marks as end mark for specific subject
     */
    private $marksAverage;

    /**
     * @var string Total percent of presents student on specific subject
     */
    private $frequency;

    /**
     * @var int The amount of days student wasn't present
     */
    private $countAbandoned;

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
     * @return float
     */
    public function getPosition () {
        return $this -> position;
    }

    /**
     * @param string | int | null $position
     */
    public function setPosition ( $position ): void {
        $this -> position = $position;
    }

    /**
     * @return string | null
     */
    public function getFrequency (): ?string {
        return $this -> frequency;
    }

    /**
     * @param string | null $frequency
     */
    public function setFrequency ( ?string $frequency ): void {
        $this -> frequency = $frequency;
    }

    /**
     * @return int
     */
    public function getCountAbandoned (): int {
        return $this -> countAbandoned;
    }

    /**
     * @param int $countAbandoned
     */
    public function setCountAbandoned ( int $countAbandoned ): void {
        $this -> countAbandoned = $countAbandoned;
    }

    #endregion

}
