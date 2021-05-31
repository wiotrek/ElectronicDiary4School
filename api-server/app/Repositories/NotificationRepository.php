<?php


namespace App\Repositories;


use App\Helpers\KeyColumn;
use App\Models\Notification;
use App\Models\NotificationType;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface {

    public function readNotification () {
        $identifier = $this->findByColumn($this->getAuthId(), KeyColumn::fromModel(User::class), User::class) ->
            pluck('identifier')[0];

        return $this->findByColumn($identifier, 'sender', Notification::class) ->
            orWhere('receiver', '=', $identifier) ->
            get();
    }


    public function readNotificationIdByType ( ?string $type ) {
        if ($this->isNotificationTypeExist($type))
            return $this->findByColumn( $type, 'type', NotificationType::class ) ->
                pluck (KeyColumn::fromModel(NotificationType::class))[0];

        return null;
    }


    public function readNotificationTypeById ( int $id ) {
        return $this->findByColumn( $id, KeyColumn::fromModel(NotificationType::class), NotificationType::class ) ->
            pluck ('type')[0];
    }


    public function isNotificationTypeExist ( ?string $type ) {
        return $this -> findByColumn( $type, 'type', NotificationType::class ) -> first();
    }

}
