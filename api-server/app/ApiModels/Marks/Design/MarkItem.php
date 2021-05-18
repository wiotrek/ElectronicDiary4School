<?php


namespace App\ApiModels\Marks\Design;


/**
 * Base details of the student mark value
 */
class MarkItem   {

    #region Protected Static Properties

    /**
     * @var int The primary key value
     */
    private $student_marks_id;

    /**
     * @var int The value
     */
    private $mark;

    /**
     * @var string The mark title for what student have mark
     */
    private $topic;

    /**
     * @var string The king of mark from what student have mark
     */
    private $kindOf;

    /**
     * @var string The passing date for specific mark
     */
    private $date;

    #endregion

    #region Accessors

    /**
     * @return int
     */
    public function getStudentMarksId (): int {
        return $this -> student_marks_id;
    }

    /**
     * @param int $student_marks_id
     */
    public function setStudentMarksId ( int $student_marks_id ): void {
        $this -> student_marks_id = $student_marks_id;
    }

    /**
     * @return int
     */
    public function getMark () {
        return $this -> mark;
    }

    /**
     * @param int $mark
     */
    public function setMark ( int $mark ): void {
        $this -> mark = $mark;
    }

    /**
     * @return string
     */
    public function getTopic () {
        return $this -> topic;
    }

    /**
     * @param string $topic
     */
    public function setTopic ( string $topic ): void {
        $this -> topic = $topic;
    }

    /**
     * @return string
     */
    public function getKindOf () {
        return $this -> kindOf;
    }

    /**
     * @param string $kindOf
     */
    public function setKindOf ( string $kindOf ): void {
        $this -> kindOf = $kindOf;
    }

    /**
     * @return string
     */
    public function getDate (): string {
        return $this -> date;
    }

    /**
     * @param string $date
     */
    public function setDate ( string $date ): void {
        $this -> date = $date;
    }

    #endregion

//    public function __toString () {
//        return self :: toString();
//    }

}
