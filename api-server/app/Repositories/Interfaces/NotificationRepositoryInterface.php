<?php


namespace App\Repositories\Interfaces;


use App\Repositories\Base\BaseRepositoryInterface;

interface NotificationRepositoryInterface extends BaseRepositoryInterface {

    public function readNotification ();

    public function readNotificationIdByType ( ?string $type );

    public function readNotificationTypeById ( int $id );

    public function isNotificationTypeExist ( ?string $type );

}
