<?php


namespace App\ApiModels\Marks;


use App\ApiModels\StudentResultApiModel;

/**
 * The data-list of marks for a single student
 */
class MarksItemViewResultApiModel {

    #region Protected Properties

    /**
     * Basic details about student
     */
    protected $student;

    /**
     * The list of the student marks
     */
    protected $marks;

    #endregion

    #region Accessors

    /**
     * @return StudentResultApiModel
     */
    public function getStudent () {
        return $this->student;
    }

    /**
     * @param StudentResultApiModel $student
     */
    public function setStudent ( StudentResultApiModel $student ): void {
        $this->student = array(
            'first_name' => $student->getFirstName(),
            'last_name' => $student->getLastName(),
            'identifier' => $student->getIdentifier()
        );
    }

    /**
     * @return mixed
     */
    public function getMarks () {
        return $this->marks;
    }

    /**
     * @param mixed $marks
     */
    public function setMarks ( $marks ): void {
        $this->marks = $marks;
    }

    #endregion


}
