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
    protected static $student_marks_id;

    /**
     * @var int The value
     */
    protected static $mark;

    /**
     * @var string The mark title for what student have mark
     */
    protected static $topic;

    /**
     * @var string The king of mark from what student have mark
     */
    protected static $kindOf;

    /**
     * @var string The passing date for specific mark
     */
    protected static $date;

    #endregion

    #region Accessors

    /**
     * @return int
     */
    public static function getStudentMarksId (): int {
        return self ::$student_marks_id;
    }

    /**
     * @param int $student_marks_id
     */
    public static function setStudentMarksId ( int $student_marks_id ): void {
        self ::$student_marks_id = $student_marks_id;
    }

    /**
     * @return int
     */
    public static function getMark () {
        return self :: $mark;
    }

    /**
     * @param int $mark
     */
    public static function setMark ( int $mark ): void {
        self :: $mark = $mark;
    }

    /**
     * @return string
     */
    public static function getTopic () {
        return self :: $topic;
    }

    /**
     * @param string $topic
     */
    public static function setTopic ( string $topic ): void {
        self :: $topic = $topic;
    }

    /**
     * @return string
     */
    public static function getKindOf () {
        return self :: $kindOf;
    }

    /**
     * @param string $kindOf
     */
    public static function setKindOf ( string $kindOf ): void {
        self :: $kindOf = $kindOf;
    }

    /**
     * @return string
     */
    public static function getDate (): string {
        return self ::$date;
    }

    /**
     * @param string $date
     */
    public static function setDate ( string $date ): void {
        self ::$date = $date;
    }

    #endregion

//    public function __toString () {
//        return self :: toString();
//    }

}
