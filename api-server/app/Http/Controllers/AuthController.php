<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
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
        $teacher = Teacher::query()->where('user_id', '=', $user->getAuthIdentifier())->select('role_id')->get();
        if ($teacher->isNotEmpty())
            $role = Role::query()->where('role_id', '=', 1)->select('status')->get();
        else
            $role = Role::query()->where('role_id', '=', 2)->select('status')->get();


        // return token
        return response([
            'message' => $user,
            'role' => $role
        ])->withCookie($cookie);

    }


    public function logout () {
        // Clear token
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }


    // Tested preview authenticated user
    public function user () {
        return Auth::user();
    }
}
