<?php


namespace App\Repositories;
use App\Repositories\Base\BaseRepositoryInterface;


interface ClassRepositoryInterface extends BaseRepositoryInterface {

    /**
     * @return mixed Get teacher classes by teacher id
     */
    public function readTeacherClasses ($subjectName);

}
