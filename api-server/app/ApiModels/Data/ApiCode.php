<?php


namespace App\ApiModels\Data;

/**
 *
 */
class ApiCode {

    public const NO_DATA = 'Please provide all required details';
    public const INCORRECT_CREDS = 'Invalid identifier or password';

    public const STORE_STUDENT_ACTIVE = 'Student activities inserted successfully';
    public const LOGOUTOK = 'Logout with success';

    public const MARKS_UPDATE_SUCCESS = 'Mark has updated successfully';
    public const MARKS_INSERT_SUCCESS = 'Mark has inserted successfully';

    public const NOTSTORE_STUDENT_ACTIVE = 'Cannot store student activities. Probably incorrect time for this subject or class or incorrect day';

}
