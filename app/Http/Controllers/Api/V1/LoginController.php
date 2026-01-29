<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password)){
             throw ValidationException::withMessages([
                'password'=> 'sorry the email or password dont match'
             ]);
        }

        $tokenObject = $user->createToken('auth_token');
        $token = $tokenObject->plainTextToken;
        //$token now this is the real token not the hash one 


        return response()->json([
            'message' => 'User login successfully',
            'user' => $user,
            'token' => $token
            ], 200);

            //the client MUST save the token i gave him so he will send it with evry request


    }
}
