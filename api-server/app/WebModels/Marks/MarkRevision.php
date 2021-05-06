<?php


namespace App\WebModels\Marks;

/**
 * Class represent information about mark
 */
class MarkRevision {

    #region private Members

    /**
     * @var string Name of the subject mark inserting from
     */
    private string $subject;

    /**
     * @var string Mark are inserting in this date
     */
    private string $date;

    /**
     * @var string Topic from what mark is insert to student
     */
    private string $topic;

    /**
     * @var string Type of mark like exam, test, ...
     */
    private string $kindOf;

    #endregion

    #region Accessors

    /**
     * @return string
     */
    public function getSubject (): string {
        return $this -> subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject ( string $subject ): void {
        $this -> subject = $subject;
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

    #endregion

}
