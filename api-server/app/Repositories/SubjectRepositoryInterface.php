<?php


namespace App\Repositories;
use App\Repositories\Base\BaseRepositoryInterface;


interface SubjectRepositoryInterface extends BaseRepositoryInterface {

    public function readTeacherSubject ();

    public function readAll();

}
