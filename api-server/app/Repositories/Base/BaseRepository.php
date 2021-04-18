<?php


namespace App\Repositories\Base;

use App\Helpers\KeyColumn;

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
}
