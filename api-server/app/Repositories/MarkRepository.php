<?php


namespace App\Repositories;


use App\Models\Mark;
use App\Models\MarksType;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\MarkRepositoryInterface;

class MarkRepository extends BaseRepository implements MarkRepositoryInterface {

    public function readMarkIdByDegree ( $degree ) {
        return $this->findByColumn( $degree, 'degree', Mark::class )->pluck('marks_id')[0];
    }

    public function readMarkTypeIdByMarkFrom ( $markFrom ) {
        return $this->findByColumn( $markFrom, 'mark_from', MarksType::class )->pluck('marks_type_id')[0];
    }
}
