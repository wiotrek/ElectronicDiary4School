<?php

namespace App\Http\Controllers;


use App\ApiModels\Base\ApiResponse;
use App\ApiModels\Data\ApiCode;
use App\ApiModels\TeacherClassResultApiModel;
use App\Helpers\RoleDetecter;
use App\Icons\IconGenerator;
use App\Services\ClassService;

class ClassController extends Controller
{
    #region  Private Members

    private $classService;

    #endregion

    #region DI Constructor

    public function __construct ( ClassService $classService) {

        $this->classService = $classService;

    }

    #endregion

    #region Request Methods

    public function showTeacherClassBySubject ($subjectName) {

        if (!RoleDetecter::isTeacher())
            return ApiResponse::unAuthenticated(ApiCode::NOT_ALLOW_CONTENT);

        $classList = $this->classService->getTeacherClasses($subjectName);

        if (is_null($classList) || ( !count( $classList ) ) > 0 )
            return ApiResponse::withEmpty(ApiCode::NO_CONTENT);


        foreach ($this->classService->getTeacherClasses($subjectName) as $teacherClass) {

            // Init new object with data
            $teacherClasses = new TeacherClassResultApiModel();
            $teacherClasses->setTeacherClass(substr($teacherClass, 10, 2));
            $teacherClasses->setIconClass(IconGenerator::getClassIcon());

            // Expand response of current data to array
            $response[] = array(
                'name'=> $teacherClasses->getTeacherClass(),
                'icon' => $teacherClasses->getIconClass()
            );

        }

        return ApiResponse::withSuccess(json_encode($response));
    }

    #endregion
}
