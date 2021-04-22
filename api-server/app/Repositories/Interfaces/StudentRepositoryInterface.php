<?php


namespace App\Repositories\Interfaces;


use App\Models\StudentActivity;
use App\Repositories\Base\BaseRepositoryInterface;

interface StudentRepositoryInterface extends BaseRepositoryInterface {

    /**
     * @param $activity StudentActivity Model with data to store
     * @return mixed
     */
    public function saveStudentActivity ( StudentActivity $activity );

}
