<?php


namespace App\ApiModels\Teacher;


class TeacherListResultApiModel extends TeacherResultApiModel {

    #region Private Members

    /**
     * @var TeacherResultApiModel
     */
    private $teacher;

    #endregion

    #region Accessors

    public function getTeacher () {
        return $this -> teacher;
    }

    /**
     * @param TeacherResultApiModel $teacher
     */
    public function setTeacher ( TeacherResultApiModel $teacher ): void {
        $this -> teacher[] = array(
            'identifier' => $teacher->getIdentifier(),
            'firstName' => $teacher->getFirstName(),
            'lastName' => $teacher->getLastName(),
            'subjectName' => $teacher->getSubjectName()
        );
    }

    #endregion

}
