<?php


namespace App\ApiModels\Data;

/**
 *
 */
class ApiCode {

    public const NO_DATA = 'Please provide all required details';
    public const INCORRECT_CREDS = 'Invalid identifier or password';
    public const IS_NOT_TEACHER_CONTENT = 'You are mistakes content. This content for student or parents only';
    public const IS_NOT_STUDENT_OR_TEACHER_CONTENT = 'It is not your content. This content for parents only';
    public const IS_NOT_STUDENT_CONTENT = 'It is not your content. This content for teachers or parents only';

    public const STORE_STUDENT_ACTIVE = 'Student activities inserted successfully';
    public const LOGOUTOK = 'Logout with success';

    public const MARKS_UPDATE_SUCCESS = 'Mark has updated successfully';
    public const MARKS_INSERT_SUCCESS = 'Mark has inserted successfully';

    public const NOTSTORE_STUDENT_ACTIVE = 'Cannot store student activities. Probably incorrect time for this subject or class or incorrect day';
    public const STUDENT_ACTIVE_NOT_FOUND = 'Not register student frequency at this date';
    public const STUDENT_SUBJECTS_NOT_FOUND = 'Student subjects not found. Probably student not exist';

    public const NOTIFICATION_INSERT_SUCCESS = 'Notification has inserted successfully';
    public const NOTIFICATION_INSERT_FAIL = 'Notification has not inserted successfully';

}
