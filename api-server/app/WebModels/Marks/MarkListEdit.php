<?php


namespace App\WebModels\Marks;

class MarkListEdit extends MarkEdit {

    #region Private Members

    private $markList;

    #endregion

    #region Accessors

    /**
     * @return array | null
     */
    public function getMarkList () {
        return $this -> markList;
    }

    /**
     * @param $markList
     */
    public function setMarkList ( $markList ): void {
        $this -> markList = $markList;
    }

    #endregion

}
