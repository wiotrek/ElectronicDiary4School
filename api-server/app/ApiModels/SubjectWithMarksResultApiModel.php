<?php


namespace App\ApiModels;


use App\ApiModels\Marks\Design\MarkItem;
use App\ApiModels\Subject\SubjectDetailsApiModel;

/**
 * Class SubjectWithMarksResultApiModel The api model represent list of marks for specific subject
 */
class SubjectWithMarksResultApiModel {

    /**
     * @var SubjectDetailsApiModel
     */
    private $subjectDetails;

    /**
     * @var MarkItem
     */
    private $marks;

    /**
     * @return SubjectDetailsApiModel
     */
    public function getSubjectDetails () {
        return $this -> subjectDetails;
    }

    /**
     * @param SubjectDetailsApiModel $subjectDetails
     */
    public function setSubjectDetails ( SubjectDetailsApiModel $subjectDetails ): void {
        $this -> subjectDetails = array(
            'name' => $subjectDetails -> getName(),
            'icon' => $subjectDetails -> getIcon(),
            'avg' => $subjectDetails -> getMarksAverage(),
            'position' => $subjectDetails -> getPosition()
        );;
    }

    /**
     * @return MarkItem
     */
    public function getMarks () {
        return $this -> marks;
    }

    /**
     * @param MarkItem $marks
     */
    public function setMarks ( MarkItem $marks ): void {
        $this -> marks[] = array(
            'mark' => $marks -> getMark(),
            'topic' => $marks -> getTopic(),
            'date' => $marks -> getDate(),
            'kindOf' => $marks -> getKindOf()
        );
    }

}
