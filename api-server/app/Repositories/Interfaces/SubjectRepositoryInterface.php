<?php


namespace App\Repositories\Interfaces;

use App\Repositories\Base\BaseRepositoryInterface;

interface SubjectRepositoryInterface extends BaseRepositoryInterface {

    public function readTeacherSubject ();

    public function readAll();

}
