<?php


namespace App\WebModels\Marks;


class MarkInsert {

    #region Private Members

    /**
     * @var string The student identifier
     */
    protected string $identifier;

    /**
     * @var string The mark value
     */
    protected string $mark;

    #endregion

    #region Accessors

    /**
     * @return string
     */
    public function getIdentifier () {
        return $this -> identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier ( string $identifier ): void {
        $this -> identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getMark () {
        return $this -> mark;
    }

    /**
     * @param string $mark
     */
    public function setMark ( string $mark ): void {
        $this -> mark = $mark;
    }

    #endregion

}
