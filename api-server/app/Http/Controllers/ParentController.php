<?php

namespace App\Http\Controllers;

use App\ApiModels\Base\ApiResponse;
use App\ApiModels\Data\ApiCode;
use App\ApiModels\Teacher\TeacherListResultApiModel;
use App\ApiModels\Teacher\TeacherResultApiModel;
use App\Helpers\RoleDetecter;
use App\Services\ParentService;
class ParentController extends Controller
{
    /**
     * @var ParentService
     */
    private $parentService;


    /**
     * TeacherController constructor.
     */
    public function __construct (ParentService $parentService) {
        $this -> parentService = $parentService;
    }

    public function showTeacherListOfStudent () {

        if (!RoleDetecter::isParent())
            return ApiResponse::unAuthenticated(ApiCode::IS_NOT_STUDENT_OR_TEACHER_CONTENT);

        $teacherListApiModel = new TeacherListResultApiModel();

        $teacherList = $this->parentService->getTeacherListOfStudent();

        foreach ( $teacherList as $teacher ) {
            $teacherItem = new TeacherResultApiModel();
            $teacherItem->setFirstName($teacher['first_name']);
            $teacherItem->setLastName($teacher['last_name']);
            $teacherItem->setSubjectName($teacher['name']);
            $teacherItem->setIdentifier($teacher['identifier']);

            $teacherListApiModel->setTeacher($teacherItem);
        }

        return ApiResponse::withSuccess($teacherListApiModel->getTeacher());
    }
}
