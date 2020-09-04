<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiginRequest;
use App\Http\Requests\SignupRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class UserController extends Controller
{


    public function signup(SignupRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->get('username'),
            'phone' => $request->phone,
            'country' => $request->country,
            'city'  => $request->city,
            'postcode' => $request->postcode,
            'name'  => $request->name,
            'address' => $request->address,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }




    public function sigin(SiginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }




    
    public function users()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], 401);

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], 401);

        } catch (JWTException $e) {

            return response()->json(['token_absent'], 401);

        }
        return response()->json(compact('user'));
    }
}
