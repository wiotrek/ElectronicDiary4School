<?php


namespace App\Repositories\Base;


interface BaseRepositoryInterface {

    public function getAuthId();

    public function getTeacherId ();

    public function getStudentId ();

    /**
     * @param $primaryKey int Primary key of specific model to identify which row is updating
     * @param $primaryColumnName string The name for primary key of the specific model
     * @param $fromModel mixed Eloquent model to update
     * @return mixed
     */
    public function updateModel ( int $primaryKey, string $primaryColumnName, $fromModel);

    public function storeModel ( object $model );

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

    /**
     * @param int $firstValue The value as right operand in first where clause
     * @param int $secondValue The value as right operand in second where clause
     * @param string $firstColumn The column by searching are data from
     * @param string $secondColumn The column by searching are data from
     * @param $fromModel
     * @return mixed
     * @see findByColumn is invoke if the first column is the same as second column
     */
    public function findByAndColumns(int $firstValue, int $secondValue, string $firstColumn, string $secondColumn, $fromModel);

    /**
     * @param $values mixed array of values to find data one by one
     * @param $columnName string The column for detect if any value is exist
     * @param $fromModel
     * @return mixed
     */
    public function findByMultipleValues ($values, string $columnName, $fromModel);

}
