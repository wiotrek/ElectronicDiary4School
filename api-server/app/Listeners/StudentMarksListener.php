<?php

namespace App\Listeners;

use App\ApiModels\Marks\Design\MarkItem;
use App\ApiModels\SubjectWithMarksResultApiModel;
use App\Events\StudentDetailsEvent;
use App\Repositories\Interfaces\MarkRepositoryInterface;

class StudentMarksListener
{
    /**
     * @var MarkRepositoryInterface
     */
    private $markRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(MarkRepositoryInterface $markRepository)
    {
        $this -> markRepository = $markRepository;
    }

    /**
     * Handle the event.
     *
     * @param StudentDetailsEvent $event
     * @return MarkItem
     */
    public function handle( StudentDetailsEvent $event)
    {
        $subjectWithMarks = new SubjectWithMarksResultApiModel();
        if (count($event -> marks) > 0 && !is_null($event -> marks)) {
            foreach ( $event -> marks as $mark ) {

                $markItem = new MarkItem();

                // for current mark get value and tag name
                $degree = $this->markRepository->readDegreeByMarkId($mark['marks_id']);
                $kindOf = $this->markRepository->readMarkFromByMarkTypeId($mark['marks_type_id']);

                // set mark details
                $markItem->setMark($degree);
                $markItem->setKindOf($kindOf);
                $markItem->setDate(substr($mark['passing_date'], 0, 10));
                $markItem->setTopic($mark['topic']);

                // expand current mark to list of marks for current subject
                $subjectWithMarks->setMarks($markItem);
            }
        }

        return $subjectWithMarks->getMarks();
    }
}
