<?php

namespace App\Http\Controllers;


use App\ApiModels\TeacherClassResultApiModel;
use App\Icons\IconGenerator;
use App\Services\TeacherClassService;

class ClassController extends Controller
{
    #region  Private Members

    private $classService;

    #endregion

    #region DI Constructor

    public function __construct (TeacherClassService $classService) {

        $this->classService = $classService;

    }

    #endregion

    #region Request Methods

    public function showTeacherClass ($subject_id) {

        foreach ($this->classService->getTeacherClasses($subject_id) as $teacherClass) {

            // Init new object with data
            $teacherClasses = new TeacherClassResultApiModel();
            $teacherClasses->setTeacherClass(substr($teacherClass, 10, 2));
            $teacherClasses->setIconClass(IconGenerator::getClassIcon());

            // Expand response of current data to array
            $response[] = array(
                'klasa'=> $teacherClasses->getTeacherClass(),
                'Icon' => $teacherClasses->getIconClass()
            );

        }

        return response(
            json_encode($response)
        );

    }

    #endregion
}
