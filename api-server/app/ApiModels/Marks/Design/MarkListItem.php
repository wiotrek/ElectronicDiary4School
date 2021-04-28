<?php


namespace App\ApiModels\Marks\Design;

use App\ApiModels\Base\ApiModel;

/**
 * The list of marks for a @see MarkItem
 */
class MarkListItem extends ApiModel{

    #region List Item Object

    protected static $marks = array();

    #endregion

    #region Accessors

    /**
     * @return array
     */
    public static function getMarks () {
        return self :: $marks;
    }

    /**
     * @param MarkItem $marks
     */
    public static function setMarks ( MarkItem $marks ): void {
        self :: $marks[] = $marks;
    }

    #endregion

    public function __toString () {
        return self :: toString();
    }

}
