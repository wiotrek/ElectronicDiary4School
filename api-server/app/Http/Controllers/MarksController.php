<?php

namespace App\Http\Controllers;

use App\ApiModels\Marks\Design\MarkItem;
use App\ApiModels\Marks\Design\MarkListItem;
use App\ApiModels\StudentResultApiModel;
use App\Repositories\StudentRepository;
use App\Services\ClassService;

class MarksController extends Controller
{
    private $classService;
    private $studentRepository;

    public function __construct(ClassService $classService, StudentRepository $studentRepository)
    {
        $this->classService = $classService;
        $this->studentRepository = $studentRepository;
    }

    public function studentMarksOfClassForSubject() {
        $myStudents = new StudentResultApiModel;
        // TODO: Below the results are on the first student. Pack this to iterate through all students and then for each student through by all their marks. Its simply.

        // Switch params with real data from outside
        $result = $this->classService->getStudentListByClass(4, "a");


        $markListItem = new MarkListItem;

        $myStudents->setFirstName($result[0]['first_name']);
        $myStudents->setLastName($result[0]['last_name']);
        $myStudents->setIdentifier($result[0]['identifier']);

        $marks = $this->studentRepository->readStudentMarks($result[0]['identifier'], 'Matematyka');

        foreach ( $marks as $mark ) {
            $markItem = new MarkItem;
            $markItem -> setMark($mark['mark']);
            $markItem -> setTopic($mark['topic']);
            $markItem -> setKindOf($mark['kindOf']);

            $markListItem -> setMarks($markItem);
        }

        return $markListItem;
    }
}
