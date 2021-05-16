<?php


namespace App\Repositories\Interfaces;


use App\Repositories\Base\BaseRepositoryInterface;

interface MarkRepositoryInterface extends BaseRepositoryInterface {

    public function readMarkIdByDegree ( $degree );

    public function readMarkTypeIdByMarkFrom ( $markFrom );

    public function readDegreeByMarkId ( int $markId );

    public function readMarkFromByMarkTypeId ( int $markTypeId );

}
