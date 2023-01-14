<?php


namespace App\Routes;

/**
 * The relative routes to all normal (non-API) calls in the server
 */
class WebRoutes {

    public const LOGOUT = '/logout';

    public const STUDENT_ACTIVE = 'student-active/{subject_name}';

    public const TEACHER_MARKS_EDIT = '/teacher-marks/edit';

    public const TEACHER_MARKS_INSERT = '/teacher-marks/insert/subject={name}/date={date}';

    public const NOTIFICATION_INSERT = '/notification/send';

    public const NOTIFICATION_CONFIRM = '/notification/confirm';

}
