<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller {
    
    public function authenticate(Request $request) {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json($this->makeErrorResponse(400, 'Invalid Credentials'), 400);
            }
        } catch (JWTException $e) {
            // return response()->json(['error' => 'could_not_create_token'], 500);
            return response()->json($this->makeErrorResponse($e->getCode(), $e->getMessage()), 500);
        }

        return response()->json($this->makeSuccessResponse(compact('token')));
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($this->makeValidatorResponse($validator->errors()), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json($this->makeSuccessResponse(compact('user','token')),201);
    }

    public function getAuthenticatedUser() {
        try {
            
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                // return response()->json(['user_not_found'], 404);
                return response()->json($this->makeErrorResponse(404, "User Not Found"), 500);
            }
            
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json($this->makeErrorResponse("Expired Token", $e->getStatusCode()), 500);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json($this->makeErrorResponse("Invalid Token", $e->getStatusCode()), 500);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json($this->makeErrorResponse("Absent Token", $e->getStatusCode()), 500);
        }

        return response()->json($this->makeSuccessResponse(compact('user')),201);
    }

}