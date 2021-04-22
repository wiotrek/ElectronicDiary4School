<?php


namespace App\Repositories;


use App\Models\StudentActivity;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Interfaces\StudentRepositoryInterface;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface {

    public function saveStudentActivity ( StudentActivity $activity ) {
        $activity -> save();
    }

}
