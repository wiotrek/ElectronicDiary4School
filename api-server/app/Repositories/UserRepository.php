<?php


namespace App\Repositories;


use App\Helpers\KeyColumn;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

    public function readFullNameByIdentifier ( string $identifier ) {
        return $this->findByColumn($identifier, 'identifier', User::class) ->
                selectRaw( 'CONCAT(first_name, " ", last_name) as full_name' ) ->
                get() ->
                pluck('full_name')[0];
    }

    public function readIdentifierByAuthId () {
        return $this->findByColumn($this->getAuthId(), KeyColumn::fromModel(User::class), User::class) ->
            pluck('identifier')[0];
    }

    public function readUserIdByIdentifier ( string $identifier ) {
        return $this->findByColumn($identifier, 'identifier', User::class) ->
        pluck(KeyColumn::fromModel(User::class))[0];
    }

    public function readTeacherIdByIdentifier ( string $identifier ) {
        $userId = $this->readUserIdByIdentifier($identifier);

        return $this->findByColumn($userId, KeyColumn::fromModel(User::class), Teacher::class) ->
        pluck(KeyColumn::fromModel(Teacher::class));
    }

    public function isTeacher ( $userId ) {
        return $this->findByColumn($userId, KeyColumn::fromModel(User::class), Teacher::class)->
            pluck('role_id')->
            first();
    }

    public function isStudent ( $userId ) {
        return $this->findByColumn($userId, KeyColumn::fromModel(User::class), Student::class)->
            pluck('role_id')->
            first();
    }

    public function isParent ( $userId ) {
        return $this->findByColumn($userId, KeyColumn::fromModel(User::class), StudentParent::class)->
            pluck('role_id')->
            first();
    }

}
