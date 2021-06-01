<?php


namespace App\Repositories\Interfaces;


use App\Repositories\Base\BaseRepositoryInterface;

interface NotificationRepositoryInterface extends BaseRepositoryInterface {

    public function readNotificationDirectPerson ( ?string $receiverIdentifier );

    public function readNotificationDirectClass ( ?string $class );

    /**
     * @param $subjectList array | null List of all subjects which student have
     * @return mixed List of subject names matching with student subjects
     */
    public function readNotificationDirectSubject ( ?array $subjectList );

    public function readNotificationDirectAll ();

    public function readNotificationIdByType ( ?string $type );

    public function readNotificationTypeById ( int $id );

    public function isNotificationTypeExist ( ?string $type );

}
