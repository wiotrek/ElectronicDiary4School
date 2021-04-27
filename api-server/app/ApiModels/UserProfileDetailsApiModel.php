<?php


namespace App\ApiModels;

use App\ApiModels\Base\ApiModel;

/**
 * The result of a login request or get user profile details request via API
 */
class UserProfileDetailsApiModel extends ApiModel {

    #region Static Protected Properties

    /**
     * Details information about authenticated user
     */
    protected static $user;

    /**
     * The user status to authenticate for access to correct content
     */
    protected static $role;

    /**
     * The link of user photo to showing on profile
     */
    protected static $profileUrl;

    /**
     * The authentication token used to stay authenticated through future requests
     */
    protected static $token;

    #endregion

    #region Get / Set

    /**
     * @return string
     */
    public static function getToken () {
        return self :: $token;
    }

    /**
     * @param string $token
     */
    public static function setToken ( string $token ): void {
        self :: $token = $token;
    }

    /**
     * @return object
     */
    public static function getUser () {
        return self :: $user;
    }

    /**
     * @param object $user
     */
    public static function setUser ( object $user ): void {
        self :: $user = $user;
    }

    /**
     * @return string
     */
    public static function getRole () {
        return self :: $role;
    }

    /**
     * @param string $role
     */
    public static function setRole ( string $role ): void {
        self :: $role = $role;
    }

    /**
     * @return string
     */
    public static function getProfileUrl () {
        return self :: $profileUrl;
    }

    /**
     * @param string $profileUrl
     */
    public static function setProfileUrl ( string $profileUrl ): void {
        self :: $profileUrl = $profileUrl;
    }

    #endregion

    public function __toString () {
        return self :: toString();
    }

}
