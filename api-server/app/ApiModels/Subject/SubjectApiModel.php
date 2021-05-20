<?php


namespace App\ApiModels\Subject;


class SubjectApiModel {

    #region Private Members

    private $name;
    private $icon;

    #endregion

    #region Accessors

    /**
     * @return string
     */
    public function getName () {
        return $this -> name;
    }

    /**
     * @param string $name
     */
    public function setName ( string $name ): void {
        $this -> name = $name;
    }

    /**
     * @return string | null
     */
    public function getIcon () {
        return $this -> icon;
    }

    /**
     * @param string | null $icon
     */
    public function setIcon ( ?string $icon ): void {
        $this -> icon = $icon;
    }

    #endregion

}
