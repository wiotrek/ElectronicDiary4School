<?php


namespace App\Repositories\Interfaces;


interface MarkRepositoryInterface {

    public function readMarkIdByDegree ( $degree );

    public function readMarkTypeIdByMarkFrom ( $markFrom );

}
