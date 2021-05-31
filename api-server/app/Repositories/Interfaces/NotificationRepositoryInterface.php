<?php


namespace App\Repositories\Interfaces;


use App\Repositories\Base\BaseRepositoryInterface;

interface NotificationRepositoryInterface extends BaseRepositoryInterface {

    public function readNotificationIdByType ( ?string $type );

    public function isNotificationTypeExist ( ?string $type );

}
