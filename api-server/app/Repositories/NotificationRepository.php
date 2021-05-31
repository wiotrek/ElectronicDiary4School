<?php


namespace App\Repositories;


use App\Helpers\KeyColumn;
use App\Models\NotificationType;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface {

    public function readNotificationIdByType ( ?string $type ) {
        if ($this->isNotificationTypeExist($type))
            return $this->findByColumn( $type, 'type', NotificationType::class ) ->
                pluck (KeyColumn::fromModel(NotificationType::class))[0];

        return null;
    }

    public function isNotificationTypeExist ( ?string $type ) {
        return $this -> findByColumn( $type, 'type', NotificationType::class ) -> first();
    }

}
