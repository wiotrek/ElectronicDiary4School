<?php


namespace App\ApiModels;


use App\ApiModels\Subject\SubjectDetailsApiModel;

class SubjectWithFrequencyResultApiModel  {

    #region Private Members

    /**
     * @var SubjectDetailsApiModel
     */
    private $subjectDetails;

    /**
     * @var array | null Collective date indicated student in this date was absent. Accept format: Y-m-d
     */
    private $days;

    #endregion

    #region Accessors

    /**
     * @return SubjectDetailsApiModel
     */
    public function getSubjectDetails () {
        return $this -> subjectDetails;
    }

    /**
     * @param SubjectDetailsApiModel $subjectDetails
     */
    public function setSubjectDetails ( SubjectDetailsApiModel $subjectDetails ): void {
        $this -> subjectDetails = array(
            'name' => $subjectDetails -> getName(),
            'icon' => $subjectDetails -> getIcon(),
            'avg' => $subjectDetails -> getFrequency(),
            'position' => $subjectDetails -> getPosition(),
            'countAbandoned' => $subjectDetails -> getCountAbandoned()
        );
    }

    /**
     * @return array|null
     */
    public function getDays (): ?array {
        return $this -> days;
    }

    /**
     * @param string|null $day
     */
    public function setDays ( ?string $day ): void {
        $this -> days[] = $day;
    }

}
