<?php


namespace App\ApiModels\Marks\Design;

use App\ApiModels\Base\ApiModel;

/**
 * The list of marks for a @see MarkItem
 */
class MarkListItem {

    #region List Item Object

    protected $marks = array();

    #endregion

    #region Accessors

    /**
     * @return array
     */
    public function getMarks () {
        return $this->marks;
    }

    /**
     * @param MarkItem $mark
     */
    public function setMarks ( MarkItem $mark ): void {
        $this->marks[] = array(
            'mark' => $mark->getMark(),
            'topic' => $mark->getTopic(),
            'kindOf' => $mark->getKindOf()
        );
    }

    #endregion

//    public function __toString () {
//        return self :: toString();
//    }

}
