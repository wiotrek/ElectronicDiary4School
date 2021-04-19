<?php


namespace App\ApiModels;

/**
 * Class TeacherClassResultApiModel The result of teacher class list details via API
 * @package App\ApiModels
 */
class TeacherClassResultApiModel {

    #region Private Members

    private $teacherClass;
    private $iconClass;

    #endregion

    #region Get / Set

    /**
     * @return mixed
     */
    public function getTeacherClass (): string {
        return $this -> teacherClass;
    }

    /**
     * @param mixed $teacherClass
     */
    public function setTeacherClass ( $teacherClass ): void {
        $this -> teacherClass = $teacherClass;
    }

    /**
     * @return mixed
     */
    public function getIconClass () {
        return $this -> iconClass;
    }

    /**
     * @param mixed $iconClass
     */
    public function setIconClass ( $iconClass ): void {
        $this -> iconClass = $iconClass;
    }

    #endregion

}
