<?php


namespace App\Services;


use App\ApiModels\Base\ApiResponse;
use App\ApiModels\Data\ApiCode;
use App\DataModels\RoleSenderNotification;
use App\Helpers\KeyColumn;
use App\Helpers\RoleDetecter;
use App\Models\Notification;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserClass;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\HarmonogramRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use App\WebModels\Notifications\NotificationSendWebModel;

class NotificationService extends BaseRepository {

    #region Private Members

    private $classRepository;
    private $notificationRepository;
    private $subjectRepository;
    private $harmonogramRepository;
    private $studentRepository;

    #endregion

    #region DI Constructor

    /**
     * NotificationService constructor.
     */
    public function __construct (ClassRepositoryInterface $classRepository,
                                                       NotificationRepositoryInterface $notificationRepository,
                                                       SubjectRepositoryInterface $subjectRepository,
                                                       HarmonogramRepositoryInterface $harmonogramRepository,
                                                       StudentRepositoryInterface $studentRepository) {
        $this -> classRepository = $classRepository;
        $this -> notificationRepository = $notificationRepository;
        $this -> subjectRepository = $subjectRepository;
        $this -> harmonogramRepository = $harmonogramRepository;
        $this -> studentRepository = $studentRepository;
    }

    #endregion

    #region Public Methods

    public function sendToPersonalNotification ( NotificationSendWebModel $notificationWebModel, string $from = RoleSenderNotification::TEACHER ) {

        // Make sure that receiver is exist in database
        if ( !$this->isIdentifierExist($notificationWebModel->getReceiver())  )
            return null;


        // For parents is possible sending message only to student Teachers
        if ( ( $from == RoleSenderNotification::PARENT ) && !$this -> isCorrectTeacherReceiver( $notificationWebModel -> getReceiver() ) )
            return null;


        if ($this->isReceiverStudent($notificationWebModel -> getReceiver()))
            return null;


        // Is need to notification eloquent model
        $notificationTypeId = $this->notificationRepository->readNotificationIdByType($notificationWebModel->getKindOf());


        // Make sure that type of notification is exist in database
        if (is_null($notificationTypeId))
            return null;

        $senderIdentifier = $this->classRepository->findByColumn($this->getAuthId(), KeyColumn::fromModel(User::class), User::class) ->
            pluck('identifier')[0];

        // Fill data to eloquent properties before save
        $notificationToSave = new Notification([
            'notification_type_id' => $notificationTypeId,
            'content' => $notificationWebModel->getContent(),
            'sender' => $senderIdentifier,
            'receiver' => $notificationWebModel->getReceiver(),
            'time_sended' => date('Y-m-d H:i' ),
            'is_readed' => false
        ]);


        // insert notification with return result 1 if insert is done with success
        return $this->notificationRepository->storeModel($notificationToSave);
    }


    public function sendToClassNotification ( NotificationSendWebModel $notificationWebModel ) {

        // Make sure that receiver as class is exist
        if ( !$this->isCorrectClassReceiver($notificationWebModel->getReceiver()) )
            return null;


        // Get all students from the class
        $studentList = $this->classRepository->readStudentsByClass(
                $notificationWebModel->getReceiver()[0], $notificationWebModel->getReceiver()[1]
        );


        // Send notification to each student chosen by teacher
        foreach ( $studentList as $student ) {
            $notificationWebModel->setReceiver('R'.$student['identifier']);
            $this->sendToPersonalNotification($notificationWebModel);
        }


        // All notification has send so return true value
        return 1;
    }


    public function sendToAllTeacherStudentsNotification ( NotificationSendWebModel $notificationWebModel ) {

        // Get all classes which are assign to teacher
        $teacherClassIdsList = $this->classRepository->readClassIdsByTeacherId($this->getTeacherId());

        foreach ( $teacherClassIdsList as $classId ) {
            $className = $this->classRepository->readClassNameByClassId($classId);

            // set current receiver class
            $notificationWebModel->setReceiver($className[0]['number'].$className[0]['identifier_number']);

            // send notification to all student from current class
            $this->sendToClassNotification($notificationWebModel);
        }

        // All notification has send so return true value
        return 1;
    }


    public function sendToAllTeacherStudentsWithSpecificSubjectNotification ( NotificationSendWebModel $notificationWebModel, string $subjectName ) {

        $subjectId = $this->subjectRepository->readSubjectIdByName($subjectName)[0];

        // Check if teacher have subject from request
        if ( !$this->subjectRepository->isSubjectExistByTeacherId( $this->getTeacherId(), $subjectId ) )
            return null;

        // List of all class ids which teacher is assign with the subject
        $classIdsList = $this->harmonogramRepository->readTeacherClassListBySubjectId($subjectId);

        foreach ( $classIdsList as $classId ) {
            $className = $this->classRepository->readClassNameByClassId($classId['user_Class_id']);

            // set current receiver class
            $notificationWebModel->setReceiver($className[0]['number'].$className[0]['identifier_number']);

            // send notification to all student from current class
            $this->sendToClassNotification($notificationWebModel);
        }

        return 1;
    }

    #endregion

    #region Private Methods

    /**
     * @param string | null $class Name of class like '4a', '7c',..
     */
    private function isClassExist ( ?string $class ) {

        if (strlen($class) != 2)
            return false;

        return $this->classRepository->isClassExist($class);
    }

    /**
     * @param string|null $identifier User identifier
     */
    private function isIdentifierExist( ?string $identifier ){
        if (is_null($identifier))
            return false;

        return $this->classRepository->findByColumn($identifier, 'identifier', User::class)->first() != null;
    }

    private function isReceiverStudent($identifier) {
        return count($this->studentRepository->readStudentIdByIdentifier($identifier)) != 0;
    }

    /**
     * Check if receiver has teacher role and also this teacher is assign to the parent student
     * @param string $identifier The receiver identifier
     */
    private function isCorrectTeacherReceiver(string $identifier) {

        $receiverUserId = $this->classRepository->findByColumn($identifier, 'identifier', User::class) ->
            pluck(KeyColumn::fromModel(User::class))[0];


        $receiverTeacherId = $this->classRepository->findIdByOtherId($receiverUserId, KeyColumn::fromModel(User::class), KeyColumn::fromModel(Teacher::class),
            Teacher::class);


        if (count($receiverTeacherId) == 0)
            return false;


        $classIdOfStudentParent = $this -> classRepository -> findByColumn(
            RoleDetecter ::convertToStudentId(),
            KeyColumn ::fromModel( Student::class ),
            Student::class ) ->
        pluck( KeyColumn::fromModel(UserClass::class) )[ 0 ];


        $classIdsOfReceiverTeacher = $this->classRepository->readClassIdsByTeacherId($receiverTeacherId);


        foreach ( $classIdsOfReceiverTeacher as $classId )
            if ($classIdOfStudentParent == $classId)
                return true;

        return false;
    }


    /**
     * Check if class which teacher sending message is assign to the teacher
     * @param string $class The receiver class. Format: '4a', '7c', ...
     */
    private function isCorrectClassReceiver(string $class) {

        if (!$this->isClassExist($class))
            return false;


        // Class ids of the teacher as sender
        $classIdsList = $this->classRepository->readClassIdsByTeacherId($this->classRepository->getTeacherId());
        // The class id of receiver
        $receiverClassId = $this->classRepository->readClassIdByIdentifierAndNumber($class[0], $class[1])[0];


        // Check if class id of receiver is anywhere in the teacher class list
        foreach ( $classIdsList as $classId )
            if ($classId == $receiverClassId)
                return true;

        return false;
    }

    #endregion

}
