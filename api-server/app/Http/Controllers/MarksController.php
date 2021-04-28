<?php

namespace App\Http\Controllers;

use App\ApiModels\Marks\Design\MarkItem;
use App\ApiModels\Marks\Design\MarkListItem;

class MarksController extends Controller
{
    public function studentMarksOfClassForSubject() {

        $markItem = new MarkItem;
        $markListItem = new MarkListItem;

        $markItem -> setMark(3);
        $markItem -> setTopic('Mnożenie i dzielenie');
        $markItem -> setKindOf('Sprawdzian');

        $markListItem -> setMarks($markItem);

        $markItem -> setMark(4);
        $markItem -> setTopic('Dodawanie i odejmowanie');
        $markItem -> setKindOf('Kartkówka');

        $markListItem -> setMarks($markItem);

        return $markListItem;
    }
}
