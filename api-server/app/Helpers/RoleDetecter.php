<?php


namespace App\Helpers;


use App\Repositories\Base\BaseRepository;


/**
 * Checking who is authenticated
 */
class RoleDetecter extends BaseRepository {

    public static function isTeacher () {
        return count( ( new self ) -> getTeacherId() );
    }

    public static function isStudent () {
        return count( ( new self ) -> getStudentId() );
    }

    public static function isParent () {
        return count( ( new self ) -> getParentId() );
    }

    /**
     * Convert parent id to student id if parent is authenticated, otherwise means that is the student
     * @return int student id
     */
    public static function convertToStudentId () {
        return (self :: isParent()) ?
            ( new self ) -> getStudentIdByParentId() :
            ( new self ) -> getStudentId()[ 0 ];
    }

}
