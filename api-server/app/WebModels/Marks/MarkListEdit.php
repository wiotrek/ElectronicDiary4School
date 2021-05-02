<?php


namespace App\WebModels\Marks;

class MarkListEdit extends MarkEdit {

    private $markList;

    public function getMarkList () {
        return $this -> markList;
    }

    /**
     * @param $markList
     */
    public function setMarkList ( $markList ): void {
        $this -> markList = $markList;
    }

}
