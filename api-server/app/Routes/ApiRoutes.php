<?php


namespace App\Routes;

/**
 * The relative routes to all Api calls in the server
 */
class ApiRoutes {

    #region Auth

    public const LOGIN = '/logowanie';

    #endregion

    #region Teacher

    public const TEACHER_SUBJECT = '/teacher/subjects';
    public const TEACHER_CLASS_OF_SUBJECT = 'teacher/subject={subjectName}/classes';

    #endregion

    #region Student

    public const STUDENTS_OF_CLASS = 'students/class={class}';

    #endregion
}
