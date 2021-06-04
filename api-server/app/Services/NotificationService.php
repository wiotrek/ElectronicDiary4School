<?php


namespace App\Services;



use App\ApiModels\Notification\NotificationListResultApiModel;
use App\ApiModels\Notification\NotificationResultApiModel;
use App\DataModels\Notification\NotificationLogo;
use App\DataModels\Notification\NotificationReceiverType;
use App\DataModels\Notification\NotificationRoleSender;
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

    public function sendNotification ( NotificationSendWebModel $notificationWebModel ) {

        // Is need to notification eloquent model
        $notificationTypeId = $this->notificationRepository->readNotificationIdByType($notificationWebModel->getKindOf());


        // Make sure that type of notification is exist in database
        if (is_null($notificationTypeId))
            return null;


        // Fill data to eloquent properties before save
        $notificationToSave = new Notification([
            'notification_type_id' => $notificationTypeId,
            'content' => $notificationWebModel->getContent(),
            'sender' => $this->userRepository->readIdentifierByAuthId(),
            'receiver' => $notificationWebModel->getReceiver(),
            'time_sended' => date('Y-m-d H:i' ),
            'is_readed' => false
        ]);


        // insert notification with return result 1 if insert is done with success
        return $this->notificationRepository->storeModel($notificationToSave);
    }

    public function sendToPersonalNotification ( NotificationSendWebModel $notificationWebModel, string $from = NotificationRoleSender::TEACHER ) {


        // Make sure that receiver is exist in database
        if ( !$this->isIdentifierExist($notificationWebModel->getReceiver())  )
            return null;


        // For parents is possible sending message only to student Teachers
        if ( ( $from == NotificationRoleSender::PARENT ) && !$this -> isStudentTeacher( $notificationWebModel -> getReceiver() ) )
            return null;


        $senderIdentifier = $this->userRepository->readIdentifierByAuthId();


        // Can't send message to self
        if ($senderIdentifier == $notificationWebModel->getReceiver())
            return null;


        // Set receiver depend on who is sending (teacher or parent)
        $receiver = $this->isStudent($notificationWebModel -> getReceiver()) ? 'R'.$notificationWebModel -> getReceiver() : $notificationWebModel -> getReceiver();
        $notificationWebModel -> setReceiver($receiver);


        return $this->sendNotification ( $notificationWebModel );
    }


    public function sendToClassNotification ( NotificationSendWebModel $notificationWebModel ) {

//        echo 'teacher id: '.$this->getTeacherId()[0]."\n";

        // Make sure that receiver as class is exist
        if ( !$this->isCorrectClassReceiver($notificationWebModel->getReceiver(), $this->getTeacherId()[0]) )
            return null;


        return $this->sendNotification($notificationWebModel);
    }


    public function sendToAllTeacherStudentsNotification ( NotificationSendWebModel $notificationWebModel ) {

        $notificationWebModel->setReceiver('all');
        return $this->sendNotification($notificationWebModel);

    }


    public function sendToAllTeacherStudentsWithSpecificSubjectNotification ( NotificationSendWebModel $notificationWebModel, string $subjectName ) {

        $subjectId = $this->subjectRepository->readSubjectIdByName($subjectName)[0];

        // Check if teacher have subject from request
        if ( !$this->subjectRepository->isSubjectExistByTeacherId( $this->getTeacherId(), $subjectId ) )
            return null;

        $notificationWebModel->setReceiver($subjectName);

        return $this->sendNotification($notificationWebModel);
    }

    #endregion

    #endregion

    #region Notification Reading

    public function getNotification () {

        $notificationList = new NotificationListResultApiModel();

        $personNotifications = $this->notificationRepository->readNotificationDirectPerson($this->userRepository->readIdentifierByAuthId());

        // Collect grouping messages for parent
        if (RoleDetecter::isParent()) {

            // The notifications for specific class from teacher
            $classNotifications = $this -> notificationRepository -> readNotificationDirectClass(
                $this -> classRepository -> readClassNameByClassId(
                    $this -> classRepository -> readClassIdByStudentIdentifier(
                        substr( $this -> userRepository -> readIdentifierByAuthId(), 1 )
                    )
                )
            );


            // Collect all student subjects
            foreach ( $this->subjectRepository->readStudentSubjects() as $subject )
                $subjectList[] = $subject['name'];


            // The notifications for all students having specific subject from teacher
            $subjectNotifications = $this -> notificationRepository-> readNotificationDirectSubject($subjectList);


            // The notifications for all students teached by teacher
            $allNotifications = $this->notificationRepository -> readNotificationDirectAll();


            foreach ( $classNotifications as $notification )
                if ( !is_null( $this -> notificationItem( $notification, NotificationReceiverType::FOR_CLASS ) ) )
                    $notificationList->setNotification($this -> notificationItem($notification, NotificationReceiverType::FOR_CLASS) );

            foreach ( $subjectNotifications as $notification ) {
                if ( !is_null( $this -> notificationItem( $notification, NotificationReceiverType::FOR_SUBJECT ) ) )
                    $notificationList -> setNotification( $this -> notificationItem( $notification, NotificationReceiverType::FOR_SUBJECT ) );
            }

            foreach ( $allNotifications as $notification )
                if ( !is_null( $this -> notificationItem( $notification, NotificationReceiverType::FOR_ALL ) ) )
                    $notificationList -> setNotification( $this -> notificationItem( $notification, NotificationReceiverType::FOR_ALL ) );
        }


        foreach ( $personNotifications as $notification )
            if ( !is_null( $this -> notificationItem( $notification, NotificationReceiverType::FOR_PERSON ) ) )
            $notificationList->setNotification($this -> notificationItem($notification, NotificationReceiverType::FOR_PERSON) );


        return $notificationList->getNotification();
    }

    public function notificationItem ( Notification $notification, string $receiverType ) {
        $notificationItem = new NotificationResultApiModel();

        // The flag indicating the sender is teacher or not. True if teacher
        $isTeacher = $this->userRepository->isTeacher($this->userRepository->readUserIdByIdentifier($notification['sender']));
        $receiver = null;


        // Before setting receiver checking for example if receiver is exist in class as receiver
        // or is having the subject as receiver and rest of necessery validation
        switch ($receiverType) {


            // Of course the receiver can be 'all' or subject name so set this
            case NotificationReceiverType::FOR_PERSON:
                $receiver = $this->isIdentifierExist($notification['receiver']) ?
                    $this->userRepository->readFullNameByIdentifier($notification['receiver']) :
                    $notification['receiver'];
                break;


            case NotificationReceiverType::FOR_CLASS:
                $receiver = $notification['receiver'];
                break;


            case NotificationReceiverType::FOR_SUBJECT:

                if ($this->isStudentTeacher($notification['sender']) )
                    foreach ($this->subjectRepository->readStudentSubjects() as $subject)
                        if ($subject['name'] == $notification['receiver'])
                            $receiver = $notification[ 'receiver' ];

                break;


            case NotificationReceiverType::FOR_ALL:

                if ($this->isStudentTeacher($notification['sender']) )
                    $receiver = $notification[ 'receiver' ];

                break;
        }


        if ($receiver == null)
            return null;


        $notificationItem->setNotificationId($notification['notification_id']);
        $notificationItem->setAvatar( $this->getAvatar( $isTeacher, $receiverType )  );
        $notificationItem->setFullName($receiver);
        $notificationItem->setDateTime($notification['time_sended']);
        $notificationItem->setKindOf($this->notificationRepository->readNotificationTypeById($notification['notification_type_id']));
        $notificationItem->setIsSender( $this->userRepository->readIdentifierByAuthId() == $notification['sender'] );
        $notificationItem->setIsReaded($notification['is_readed']);
        $notificationItem->setSubject($this->getSubject($isTeacher ? $notification['sender'] : $notification['receiver']));
        $notificationItem->setMessage($notification['content']);
        $notificationItem->setIdentifier($notification['sender']);

        return $notificationItem;
    }

    #endregion

    #region Notification Confirm

    /**
     * @param $notificationIds array|null The list ids of notification to update status message
     */
    public function putNotificationStatus ( ?array $notificationIds ) {

        foreach ( $notificationIds as $notificationId ) {

            // Update status if notification exist
            if (!is_null($this->notificationRepository->readNotificationById($notificationId)))
                return $this -> notificationRepository -> updateNotificationStatus( $notificationId );
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

    private function isStudent( $identifier) {
        return count($this->studentRepository->readStudentIdByIdentifier($identifier)) != 0;
    }

    /**
     * Check if teacher is assign to the parent student
     * @param string $identifier The teacher identifier
     */
    private function isStudentTeacher( string $identifier) {

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
     * Check if class which teacher sending message is assign to the user
     * @param string $class The receiver class. Format: '4a', '7c', ...
     */
    private function isCorrectClassReceiver(string $class, int $userId) {

//        echo 'user id: '."\n";
        if (!$this->isClassExist($class))
            return false;


        // Class ids of the user
        $classIdsList = $this->classRepository->readClassIdsByTeacherId($userId);
        // The class id of receiver
        $userClassId = $this->classRepository->readClassIdByIdentifierAndNumber($class[0], $class[1])[0];


        // Check if class id of receiver is anywhere in the teacher class list
        foreach ( $classIdsList as $classId ) {
            if ( $classId == $userClassId )
                return true;
        }

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

    private function getAvatar( bool $isTeacher, string $receiverType ) {

        if ($isTeacher) {
            if ( $receiverType != NotificationReceiverType::FOR_PERSON )
                $avatar = NotificationLogo::FOR_GROUP;
            else
                $avatar =  NotificationLogo::FOR_TEACHER;
        }
        else
            $avatar = NotificationLogo::FOR_PARENT;

        return $avatar;
    }

    #endregion

}
