<?php


namespace App\ApiModels;


use App\ApiModels\Marks\Design\MarkWithTagItem;

/**
 * Class SubjectWithMarksResultApiModel The api model represent list of marks for specific subject
 */
class SubjectWithMarksResultApiModel {

    private $subjectName;

    /**
     * @var MarkWithTagItem
     */
    private $marks;

    /**
     * @return string
     */
    public function getSubjectName () {
        return $this -> subjectName;
    }

    /**
     * @param string $subjectName
     */
    public function setSubjectName ( string $subjectName ): void {
        $this -> subjectName = $subjectName;
    }

    /**
     * @return MarkWithTagItem
     */
    public function getMarks () {
        return $this -> marks;
    }

    /**
     * @param MarkWithTagItem $marks
     */
    public function setMarks ( MarkWithTagItem $marks ): void {
        $this -> marks[] = array(
            'mark' => $marks -> getMarkValue(),
            'tag' => $marks -> getTagName()
        );
    }

}
