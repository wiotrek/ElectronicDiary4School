<?php


namespace App\ApiModels\Marks\Design;


use App\ApiModels\Base\ApiModel;

/**
 * Base details of the student mark value
 * TODO: Probably going to extend with date mark assign
 */
class MarkItem   {

    #region Protected Static Properties

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

    #endregion

    #region Accessors

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

    #endregion

//    public function __toString () {
//        return self :: toString();
//    }

}
