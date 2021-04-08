<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request) {

        // Get user from table by identifier
        $user = DB::table('user')->where('identifier', '=', $request->identifier);


        // Return bad request if user not exist
        if (is_null($user->value('hash_pass')))
            return new JsonResponse('Nie poprawny identyfikator lub hasło', 400);


        // Get user password from hash_pass column
        $userPassword = $user->value('hash_pass');


        // The flag indicates if password is correct
        $isPasswordCorrect = password_verify($request->password, $userPassword);


        // Return token for login user
        if ($isPasswordCorrect)
            return new JsonResponse(Str::random(60), 200);
        else
            return new JsonResponse('Nie poprawny identyfikator lub hasło', 400);


    }
}
