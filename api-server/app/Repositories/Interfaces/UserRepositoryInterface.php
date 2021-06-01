<?php


namespace App\Repositories\Interfaces;


use App\Repositories\Base\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface {

    public function readFullNameByIdentifier(string $identifier);

    public function readIdentifierByAuthId ();

    public function readUserIdByIdentifier ( string $identifier );

    public function readTeacherIdByIdentifier ( string $identifier );

    public function isTeacher ( $userId );

    public function isStudent ( $userId );

    public function isParent ( $userId );

}
