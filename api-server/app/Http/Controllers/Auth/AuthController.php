<?php

namespace App\Http\Controllers\Auth;

use App\ApiModels\Base\ApiResponse;
use App\ApiModels\Data\ApiCode;
use App\ApiModels\UserProfileDetailsApiModel;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

/*
 * Controller taking authenticated user to home page
 * or back to login page after logout
 */
class AuthController extends Controller
{
    #region  Private Members

    private $userRepository;

    #endregion

    #region DI Constructor

    public function __construct (BaseRepositoryInterface $userRepository) {

        $this->userRepository = $userRepository;

    }

    #endregion

    public function login(Request $request) {

        $userToReturn = new UserProfileDetailsApiModel;

        // Verify that credentials are correct
        if (!Auth::attempt($request -> only('identifier', 'password')))
            return ApiResponse::unAuthenticated(ApiCode::INCORRECT_CREDS);


        // If okay then create token with cookie for authenticated user
        $userToReturn->setUser(Auth::user());
        $userToReturn->setToken($userToReturn->getUser()->createToken('token')->plainTextToken);
        $cookie = cookie('jwt', $userToReturn->getToken(), 60 * 24);


        // Get school status of the login user
        $teacherRole =$this->userRepository->findByColumn($this->userRepository->getAuthId(), "user_id", Teacher::class)->pluck('role_id')->first();
        $studentRole = $this->userRepository->findByColumn($this->userRepository->getAuthId(), "user_id", Student::class)->pluck('role_id')->first();
        $parentRole = $this->userRepository->findByColumn($this->userRepository->getAuthId(), "user_id", StudentParent::class)->pluck('role_id')->first();


        if (!is_null($teacherRole))
            $userToReturn->setRole($this->userRepository->findByColumn($teacherRole, 'role_id', Role::class)->pluck('status')->first());
        else if (!is_null($studentRole))
            $userToReturn->setRole($this->userRepository->findByColumn($studentRole, 'role_id', Role::class)->pluck('status')->first());
        else
            $userToReturn->setRole($this->userRepository->findByColumn($parentRole, 'role_id', Role::class)->pluck('status')->first());


        $profilePhoto = $this->userRepository->findByColumn($this->userRepository->getAuthId(), 'user_id', User::class)->pluck('profile_photo')->first();

        if (is_null($profilePhoto))
            $profilePhoto = 'https://randomuser.me/api/portraits/women/1.jpg';


        $userToReturn->setProfileUrl($profilePhoto);


        // return user
        return ApiResponse::withSuccess($userToReturn)->withCookie($cookie);

    }


    public function logout () {
        // Clear token
        $cookie = Cookie::forget('jwt');

        return ApiResponse::withSuccess (null,ApiCode::LOGOUTOK)->withCookie($cookie);
    }

}
