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

    public function readDegreeByMarkId ( int $markId ) {
        return $this->findByColumn($markId, 'marks_id', Mark::class)->pluck('degree')[0];
    }

    public function readMarkFromByMarkTypeId ( int $markTypeId ) {
        return $this->findByColumn($markTypeId, 'marks_type_id', MarksType::class)->pluck('mark_from')[0];
    }


}
