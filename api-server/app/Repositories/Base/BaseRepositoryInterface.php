<?php


namespace App\Repositories\Base;


interface BaseRepositoryInterface {

    /**
     * Select whatever from giving $modelName
     * @param $model string Eloquent model for retrieve data
     */
    public function all ( string $model );

    /**
     * Get object of model by id
     * @param $id int The value to where clause as right operand
     * @param $model string Eloquent model for retrieve data
     * @return mixed
     */
    public function findById ( int $id, string $model );

    /**
     * @param $byIdValue int The value to where clause as right operand
     * @param $byIdColumn string Primary key of specific model
     * @param $getIdColumn string The Primary key of specific model to return
     * @param $fromModel string Eloquent model to from clause
     * @return mixed
     */
    public function findIdByOtherId ( int $byIdValue, string $byIdColumn, string $getIdColumn, string $fromModel );

    /**
     * @param mixed $value The value as right operand in where clause
     * @param string $columnName The column by searching are data from
     * @param string $fromModel Eloquent model to explore
     * @return mixed
     */
    public function findByColumn($value, string $columnName, string $fromModel);

}
