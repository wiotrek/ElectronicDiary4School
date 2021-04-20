<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

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

        // Verify that credentials are correct
        if (!Auth::attempt($request -> only('identifier', 'password'))){
            return response([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // If okay then create token with cookie for authenticated user
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24);


        // Get school status of the login user
        $teacherRole =$this->userRepository->findByColumn($this->userRepository->getAuthId(), "user_id", Teacher::class)->pluck('role_id')->first();
        $studentRole = $this->userRepository->findByColumn($this->userRepository->getAuthId(), "user_id", Student::class)->pluck('role_id')->first();
        if (!is_null($teacherRole))
            $role = $this->userRepository->findByColumn($teacherRole, 'role_id', Role::class)->pluck('status')->first();
        else
            $role = $this->userRepository->findByColumn($studentRole, 'role_id', Role::class)->pluck('status')->first();


        // TODO: extend user table with url profile photo
        $userProfile = "https://randomuser.me/api/portraits/women/60.jpg";


        // return token
        return response([
            'message' => $user,
            'role' => $role,
            'profileUrl' => $userProfile,
            'token' => $token
        ])->withCookie($cookie);

    }


    public function logout () {
        // Clear token
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

}
