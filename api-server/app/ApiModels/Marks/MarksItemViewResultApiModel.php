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
    protected static $student;

    /**
     * The list of the student marks
     */
    protected static $marks;

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
     * @return mixed
     */
    public static function getMarks () {
        return self :: $marks;
    }

    /**
     * @param mixed $marks
     */
    public static function setMarks ( $marks ): void {
        self :: $marks = $marks;
    }

    #endregion

}
