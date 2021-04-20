<?php


namespace App\Repositories\Base;

use App\Helpers\KeyColumn;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BaseRepository implements BaseRepositoryInterface {

    public function all ( $model ) {
        return $model::get();
    }


    public function findById ( int $id, $model ) {
        return $model::where(KeyColumn::name($model), '=', $id)->get();
    }


    public function findIdByOtherId ( $byIdValue, $byIdColumn, $getIdColumn, $fromModel ) {
        return $fromModel::query()->where($byIdColumn, '=', $byIdValue)->pluck($getIdColumn);
    }

    public function findByColumn ( $value, $columnName, $fromModel ) {
        return $fromModel::query()->where($columnName, '=', $value);
    }

    /**
     * @return mixed Taking id of the login user
     */
    protected function getAuthId() {
        return Auth::user()->getAuthIdentifier();
    }

    /**
     * @return mixed Taking teacher id by id of the login user
     */
    protected function getTeacherId() {
        return $this->findIdByOtherId(
            $this->getAuthId(),
            KeyColumn::name(User::class),
            KeyColumn::name(Teacher::class),
            Teacher::class);
    }

    /**
     * @return mixed Taking student id by id of the login user
     */
    protected function getStudentId() {
        return $this->findIdByOtherId(
            $this->getAuthId(),
            KeyColumn::name(User::class),
            KeyColumn::name(Student::class),
            Student::class);
    }
}
