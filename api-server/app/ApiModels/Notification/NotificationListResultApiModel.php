<?php


namespace App\ApiModels\Notification;


class NotificationListResultApiModel extends NotificationResultApiModel {

    /**
     * The list of user notifications
     * @var array | null
     */
    private $notification;

    /**
     * @return array|null list of all user notifications
     */
    public function getNotification () {
        return $this -> notification;
    }

    /**
     * @param NotificationResultApiModel $notificationItem The single user notification
     */
    public function setNotification ( NotificationResultApiModel $notificationItem ): void {
        $this->notification[] = array(
            'avatar' => $notificationItem->getAvatar(),
            'fullName' => $notificationItem->getFullName(),
            'dateTime' => $notificationItem->getDateTime(),
            'kindOf' => $notificationItem->getKindOf(),
            'isSender' => $notificationItem->IsSender(),
            'isReaded' => $notificationItem->isReaded(),
            'subject' => $notificationItem->getSubject(),
            'message' => $notificationItem->getMessage(),
            'identifier' => $notificationItem->getIdentifier()
        );
    }

}
