<?php


namespace App\ApiModels\Frequency;


use App\Serialization\JsonBuilder\Parts\JsonObject;

class StudentFrequencyListResultApiModel extends JsonObject {

    #region Protected Static Members

    /**
     * @var bool The flag indicate teacher can send send list or review only
     */
    protected static $readonly;

    /**
     * @var string The student active list status for this date
     */
    protected static $date;

    /**
     * @var StudentFrequencyResultApiModel
     */
    protected static $studentListActivity;

    #endregion

    #region Accessors

    /**
     * @return bool
     */
    public static function getReadonly () {
        return self :: $readonly;
    }

    /**
     * @param bool $readonly
     */
    public static function setReadonly ( bool $readonly ): void {
        self :: $readonly = $readonly;
    }

    /**
     * @return string
     */
    public static function getDate () {
        return self :: $date;
    }

    /**
     * @param string $date
     */
    public static function setDate ( string $date ): void {
        self :: $date = $date;
    }

    /**
     * @return StudentFrequencyResultApiModel
     */
    public static function getStudentListActivity () {
        return self :: $studentListActivity;
    }

    /**
     * @param StudentFrequencyResultApiModel $studentListActivity
     */
    public static function setStudentListActivity ( StudentFrequencyResultApiModel $studentListActivity ): void {
        self :: $studentListActivity = array(
            'student' => $studentListActivity -> getStudent(),
            'isActive' => $studentListActivity -> getIsActive()
        );
    }

    #endregion

    public function __toString () {
        return self :: createJsonObject();
    }

}
