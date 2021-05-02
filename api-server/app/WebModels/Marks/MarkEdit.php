<?php


namespace App\WebModels\Marks;


class MarkEdit {

    #region Private Members

    /**
     * @var int The primary key of the student_marks table
     */
    private $student_marks_id;

    /**
     * @var string The mark value
     */
    private $mark;

    #endregion

    #region Accessors

    /**
     * @return int
     */
    public function getStudentMarksId () {
        return $this -> student_marks_id;
    }

    /**
     * @param mixed $student_marks_id
     */
    public function setStudentMarksId ( $student_marks_id ): void {
        $this -> student_marks_id = $student_marks_id;
    }

    /**
     * @return string
     */
    public function getMark () {
        return $this -> mark;
    }

    /**
     * @param mixed $mark
     */
    public function setMark ( $mark ): void {
        $this -> mark = $mark;
    }

    #endregion

}
