<?php


namespace App\ApiModels;

/**
 * The result of a login request or get user profile details request via API
 */
class UserProfileDetailsApiModel {

    /**
     * The authentication token used to stay authenticated through future requests
     */
    public $token;

    /**
     * Details information about authenticated user
     */
    public $user;

    /**
     * The user status to authenticate for access to correct content
     */
    public $role;

    /**
     * The link of user photo to showing on profile
     */
    public $profileUrl;


    public function __toString () {
        return
        '{'."\n\t".
            '"message": '.$this->user.','."\n\t".
            '"role": "'.$this->role.'"'.','."\n\t".
            '"profileUrl": "'.$this->profileUrl.'",'."\n\t".
            '"token": "'.$this->token.'"'."\n".
        '}';
    }

}
