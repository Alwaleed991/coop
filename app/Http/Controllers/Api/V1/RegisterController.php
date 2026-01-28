<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Validated;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
       $user = User::create($request->validated());

        $tokenObject = $user->createToken('auth_token');
        $token = $tokenObject->plainTextToken;

         return response()->json([
            'message' => 'User registerd successfully',
            'user' => $user,
            'token' => $token
            ], 201);


    }
}
