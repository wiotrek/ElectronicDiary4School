<?php


namespace App\Repositories\Interfaces;


use App\Repositories\Base\BaseRepositoryInterface;

interface MarkRepositoryInterface extends BaseRepositoryInterface {

    public function readMarkIdByDegree ( $degree );

    public function readMarkTypeIdByMarkFrom ( $markFrom );

}
