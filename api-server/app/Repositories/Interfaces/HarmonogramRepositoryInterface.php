<?php


namespace App\Repositories\Interfaces;


use App\Repositories\Base\BaseRepositoryInterface;

interface HarmonogramRepositoryInterface extends BaseRepositoryInterface {

    /**
     * Check if teacher have lesson by provided args
     * @param $classId int
     * @param $subjectId int
     * @param $day string The name of day in polish language
     * @param $startTime string The time with format H:i which lesson is starting
     * @return int primary key if founded, 0 otherwise
     */
    public function isExistLesson ( int $classId, int $subjectId, string $day, string $startTime );

}
