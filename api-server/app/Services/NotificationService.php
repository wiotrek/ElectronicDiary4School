<?php


namespace App\Services;



use App\ApiModels\Notification\NotificationListResultApiModel;
use App\ApiModels\Notification\NotificationResultApiModel;
use App\DataModels\NotificationLogo;
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
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\WebModels\Notifications\NotificationSendWebModel;

class NotificationService extends BaseRepository {

    #region Private Members

    private $classRepository;
    private $notificationRepository;
    private $subjectRepository;
    private $harmonogramRepository;
    private $studentRepository;
    private $userRepository;

    #endregion

    #region DI Constructor

    /**
     * NotificationService constructor.
     */
    public function __construct (ClassRepositoryInterface $classRepository,
                                                       NotificationRepositoryInterface $notificationRepository,
                                                       SubjectRepositoryInterface $subjectRepository,
                                                       HarmonogramRepositoryInterface $harmonogramRepository,
                                                       StudentRepositoryInterface $studentRepository,
                                                       UserRepositoryInterface $userRepository) {

        $this -> classRepository = $classRepository;
        $this -> notificationRepository = $notificationRepository;
        $this -> subjectRepository = $subjectRepository;
        $this -> harmonogramRepository = $harmonogramRepository;
        $this -> studentRepository = $studentRepository;
        $this -> userRepository = $userRepository;

    }

    #endregion

    #region Notification Sending

    #region Public Methods

    public function sendToPersonalNotification ( NotificationSendWebModel $notificationWebModel, string $from = RoleSenderNotification::TEACHER ) {

        // Make sure that receiver is exist in database
        if ( !$this->isIdentifierExist($notificationWebModel->getReceiver())  )
            return null;


        // For parents is possible sending message only to student Teachers
        if ( ( $from == RoleSenderNotification::PARENT ) && !$this -> isCorrectTeacherReceiver( $notificationWebModel -> getReceiver() ) )
            return null;


        // Is need to notification eloquent model
        $notificationTypeId = $this->notificationRepository->readNotificationIdByType($notificationWebModel->getKindOf());


        // Make sure that type of notification is exist in database
        if (is_null($notificationTypeId))
            return null;


        $senderIdentifier = $this->classRepository->findByColumn($this->getAuthId(), KeyColumn::fromModel(User::class), User::class) ->
            pluck('identifier')[0];


        // Can't send message to self
        if ($senderIdentifier == $notificationWebModel->getReceiver())
            return null;


        // Fill data to eloquent properties before save
        $notificationToSave = new Notification([
            'notification_type_id' => $notificationTypeId,
            'content' => $notificationWebModel->getContent(),
            'sender' => $senderIdentifier,
            'receiver' => $this->isStudent($notificationWebModel -> getReceiver()) ? 'R'.$notificationWebModel -> getReceiver() : $notificationWebModel -> getReceiver(),
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

    #endregion

    #region Notification Reading

    public function getNotification () {

        $notificationList = new NotificationListResultApiModel();
        $notificationItem = new NotificationResultApiModel();
        $notificationListfromDB = $this->notificationRepository->readNotification();

        if (count($notificationListfromDB) == 0)
            return null;

        foreach ( $notificationListfromDB as $notification ) {

            // The flag indicating the sender is teacher or not. True if teacher
            $isTeacher = $this->userRepository->isTeacher($this->userRepository->readUserIdByIdentifier($notification['sender']));

            $notificationItem->setAvatar( $isTeacher ? NotificationLogo::FOR_TEACHER : NotificationLogo::FOR_PARENT  );
            $notificationItem->setFullName($this->userRepository->readFullNameByIdentifier($notification['sender']));
            $notificationItem->setDateTime($notification['time_sended']);
            $notificationItem->setKindOf($this->notificationRepository->readNotificationTypeById($notification['notification_type_id']));
            $notificationItem->setIsSender( $this->userRepository->readIdentifierByAuthId() == $notification['sender'] );
            $notificationItem->setIsReaded($notification['is_readed']);
            $notificationItem->setSubject($this->getSubject($isTeacher ? $notification['sender'] : $notification['receiver']));
            $notificationItem->setMessage($notification['content']);
            $notificationItem->setIdentifier($notification['sender']);

            $notificationList->setNotification($notificationItem);
        }

        return $notificationList->getNotification();
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

    private function isStudent( $identifier) {
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

    /**
     * @param string $teacherIdentifier The teacher identifier as sender or receiver
     * @return string Subject name which is teached by teacher
     */
    private function getSubject(string $teacherIdentifier) {
        $userId = $this->userRepository->readUserIdByIdentifier($teacherIdentifier);

        // Get subject name depend on teacher is sender or receiver
        if ($this->userRepository->isTeacher($userId)) {
            $teacherId = $this -> userRepository -> readTeacherIdByIdentifier( $teacherIdentifier );
            return $this->subjectRepository->readSubjectNameByTeacherId($teacherId);
        }
        else
            return $this -> subjectRepository -> readSubjectNameByTeacherId( $this -> getTeacherId()[ 0 ] );

    }

    #endregion

}
