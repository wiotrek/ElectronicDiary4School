<?php


namespace App\ApiModels\Base;

use App\ApiModels\Data\ApiHttpCode;

/**
 * The response for all Web API calls made
 */
class ApiResponse {

    /**
     * @param $data object | array | null The result to return
     * @param $message string | null Additional information to return
     */
    public static function withSuccess ( $data, $message = null ) {
        return !is_null($message) ?
            response( ['message' => $message], ApiHttpCode::OK ) :
            response( $data, ApiHttpCode::OK );
    }

    /**
     * @param $api_code string The message to return about what was wrong
     * @param $http_code int The http status
     */
    public function responseWithError ( string $api_code, int $http_code ) {
        return response( [
            'message' => $api_code
        ] , $http_code );
    }

    /**
     * Requests are detect as incorrect from client
     * @param $api_code string The message to return about what was wrong
     */
    public static function badRequest ( string $api_code ) {
        return ( new self ) -> responseWithError( $api_code, ApiHttpCode::BADREQUEST );
    }

    /**
     * @param $api_code string The message to return about what was wrong
     */
    public static function unAuthenticated ( string $api_code ) {
        return ( new self ) -> responseWithError( $api_code, ApiHttpCode::UNAUTHENTICATED );
    }

    /**
     * @param $api_code string The message to return about what was wrong
     */
    public static function notFound ( string $api_code ) {
        return ( new self ) -> responseWithError( $api_code, ApiHttpCode::NOTFOUND );
    }

}
