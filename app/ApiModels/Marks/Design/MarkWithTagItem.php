<?php


namespace App\ApiModels\Marks\Design;


class MarkWithTagItem {

    #region Private Members

    private $markValue;

    /**
     * @var string The first letter of the mark type word
     */
    private $tagName;

    #endregion

    #region Accessors

    /**
     * @return int
     */
    public function getMarkValue () {
        return $this -> markValue;
    }

    /**
     * @param int $markValue
     */
    public function setMarkValue ( int $markValue ): void {
        $this -> markValue = $markValue;
    }

    /**
     * @return string
     */
    public function getTagName () {
        return $this -> tagName;
    }

    /**
     * @param string $tagName
     */
    public function setTagName ( string $tagName ): void {
        $this -> tagName = $tagName;
    }

    #endregion

}
