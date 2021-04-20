<?php


namespace App\Repositories\Interfaces;
use App\Repositories\Base\BaseRepositoryInterface;


interface ClassRepositoryInterface extends BaseRepositoryInterface {

    /**
     * @return mixed Get teacher classes by teacher id
     */
    public function readTeacherClasses ($subjectName);

}
