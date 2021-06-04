<?php


namespace App\Repositories;


use App\Helpers\KeyColumn;
use App\Models\Notification;
use App\Models\NotificationType;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface {

    public function readNotificationDirectPerson ( ?string $receiverIdentifier ) {
        return $this->findByColumn($receiverIdentifier, 'sender', Notification::class) ->
            orWhere('receiver', '=', $receiverIdentifier) ->
            get();
    }

    public function readNotificationDirectClass ( ?string $class ) {
        return $this->findByColumn($class, 'receiver', Notification::class) ->
        get();
    }

    public function readNotificationDirectSubject ( ?array $subjectList ) {
        return Notification::query()->
            whereIn('receiver', $subjectList)->
            get();
    }

    public function readNotificationDirectAll () {
        return $this->findByColumn('all', 'receiver', Notification::class) ->
        get();
    }

    public function readNotificationById ( $notificationId ) {
        return $this->findByColumn($notificationId, KeyColumn::fromModel(Notification::class), Notification::class) ->
            first();
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

    public function updateNotificationStatus ( int $notificationId ) {
        return $this->updateModel($notificationId, KeyColumn::fromModel(Notification::class), Notification::class) ->
        update([
            'is_readed' => 1,
        ]);
    }
}
