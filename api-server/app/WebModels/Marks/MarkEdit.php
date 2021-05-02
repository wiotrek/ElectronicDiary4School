<?php


namespace App\WebModels\Marks;

class MarkEdit {

    #region Private Members

    private $student_marks_id;
    private $mark;

    #endregion

    #region Accessors

    /**
     * @return mixed
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
     * @return mixed
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
