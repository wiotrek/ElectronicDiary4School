<?php

namespace App\Http\Controllers;

use App\ApiModels\Base\ApiResponse;
use App\ApiModels\Data\ApiCode;
use App\DataModels\RoleSenderNotification;
use App\Helpers\RoleDetecter;
use App\Services\NotificationService;
use App\WebModels\Notifications\NotificationSendWebModel;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $notificationService;


    public function __construct ( NotificationService $notificationService ) { $this -> notificationService = $notificationService; }


    public function insertNotification (Request $request) {

        // Unauth if student trying send message from outside tool
        if(RoleDetecter::isStudent())
            return ApiResponse::unAuthenticated(ApiCode::IS_NOT_STUDENT_CONTENT);


        // Initialize data from request
        $notificationWebModel = new NotificationSendWebModel();
        $notificationWebModel->setKindOf($request['kindOf']);
        $notificationWebModel->setContent($request['content']);
        $notificationWebModel->setReceiver($request['receiver']);


        $result = null;

        // Sending message from parent
        if (RoleDetecter::isParent())
            $result = $this->notificationService->sendToPersonalNotification($notificationWebModel,  RoleSenderNotification::PARENT);


        // Sending message from teacher with match receiver type
        if (RoleDetecter::isTeacher()) {

            if ( $notificationWebModel -> getReceiver() == 'all' && !is_null( $request[ 'subject' ] ) )
                $result = $this -> notificationService -> sendToAllTeacherStudentsWithSpecificSubjectNotification( $notificationWebModel, $request[ 'subject' ] );

            else if ( strlen( $notificationWebModel -> getReceiver() ) == 2 )
                $result = $this -> notificationService -> sendToClassNotification( $notificationWebModel );

            else if ( $notificationWebModel -> getReceiver() == 'all' )
                $result = $this -> notificationService -> sendToAllTeacherStudentsNotification( $notificationWebModel );

            else
                $result = $this->notificationService->sendToPersonalNotification($notificationWebModel);

        }


        return $result != null ?
            ApiResponse::withSuccess(null, ApiCode::NOTIFICATION_INSERT_SUCCESS) :
            ApiResponse::badRequest(ApiCode::NOTIFICATION_INSERT_FAIL);
    }
}