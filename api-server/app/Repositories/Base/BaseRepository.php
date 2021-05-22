<?php


namespace App\Repositories\Base;

use App\Helpers\KeyColumn;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BaseRepository implements BaseRepositoryInterface {

    #region Implemented Methods

    public function all ( $model ) {
        return $model::get();
    }

    public function updateModel ( int $primaryKey, string $primaryColumnName, $fromModel) {
        return $fromModel::query()->
        where($primaryColumnName, '=', $primaryKey);
    }

    public function storeModel ( object $model ) {
        $model->save();
    }

    public function findById ( int $id, $model ) {
        return $model::where(KeyColumn::fromModel($model), '=', $id)->get();
    }


    public function findIdByOtherId ( $byIdValue, $byIdColumn, $getIdColumn, $fromModel ) {
        return $fromModel::query()->where($byIdColumn, '=', $byIdValue)->pluck($getIdColumn);
    }

    public function findByColumn ( $value, $columnName, $fromModel ) {
        return $fromModel::query()->where($columnName, '=', $value);
    }

    public function findByAndColumns( $firstValue, $secondValue, $firstColumn, $secondColumn, $fromModel ) {
        if ($firstColumn != $secondColumn)
            return $fromModel::query()->where($firstColumn, '=', $firstValue)->where($secondColumn, '=', $secondValue);
        else
            return $this->findByColumn($firstValue, $firstColumn, $fromModel);
    }

    public function findByMultipleValues ($values, string $columnName, $fromModel) {
        return $fromModel::query()->whereIn($columnName, $values);
    }

    #endregion

    #region Protected Methods

    /**
     * @return mixed Taking id of the login user
     */
    public function getAuthId() {
        return Auth::user()->getAuthIdentifier();
    }

    /**
     * @return mixed Taking teacher id by id of the login user
     */
    public function getTeacherId() {
        return $this->findIdByOtherId(
            $this->getAuthId(),
            KeyColumn::fromModel(User::class),
            KeyColumn::fromModel(Teacher::class),
            Teacher::class);
    }

    /**
     * @return mixed Taking student id by id of the login user
     */
    public function getStudentId() {
        return $this->findIdByOtherId(
            $this->getAuthId(),
            KeyColumn::fromModel(User::class),
            KeyColumn::fromModel(Student::class),
            Student::class);
    }

    #endregion
}
