<?php


namespace App\ApiModels;

use App\Serialization\JsonBuilder\Parts\JsonObject;

/**
 * Class TeacherClassResultApiModel The result of teacher class list details via API
 * @package App\ApiModels
 */
class TeacherClassResultApiModel extends JsonObject {

    #region Private Members

    protected static $teacherClass;
    protected static $iconClass;

    #endregion

    #region Get / Set

    /**
     * @return mixed
     */
    public function getTeacherClass (): string {
        return self :: $teacherClass;
    }

    /**
     * @param mixed $teacherClass
     */
    public function setTeacherClass ( $teacherClass ): void {
        self :: $teacherClass = $teacherClass;
    }

    /**
     * @return mixed
     */
    public function getIconClass () {
        return self :: $iconClass;
    }

    /**
     * @param mixed $iconClass
     */
    public function setIconClass ( $iconClass ): void {
        self :: $iconClass = $iconClass;
    }

    #endregion

    public function __toString () {
        return self :: createJsonObject();
    }

}
