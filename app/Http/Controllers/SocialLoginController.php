<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Socialite;
use JWTAuth;

class SocialLoginController extends Controller {


    public function show($driver) {
        return Socialite::driver($driver)->redirect();
    }

    public function facebook () {
        $user = Socialite::driver('facebook')->user();
        
        $socialUser = User::where('email', $user->email)->first();

        $password = str_random(8);
        if (!$socialUser) {
            $newUser = User::create([
                'email' => $user->email,
                'name' => $user->name,
                'password' => Hash::make($password)
            ]);

            $socialUser = $newUser;
        }

        $token = JWTAuth::fromUser($socialUser);

        return response()->json(compact('token'), 200);

    }

    public function login (Request $request) {

        $fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_ID_API'),
            'app_secret' => env('FACEBOOK_SECRET_API'),
            'default_graph_version' => 'v2.10',
            //'default_access_token' => '{access-token}', // optional
        ]);

        try {
            $response = $fb->get('/me?fields=id,name,email', $request->token);
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), 500), 400);
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), 500), 400);
        }catch (\Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), 500), 400);
        }

        $me = $response->getGraphUser();
        $user = User::where('email', $me->getEmail())->first();

        $password = str_random(8);
        if (!$user) {
            $newUser = User::create([
                'email' => $me->getEmail(),
                'name' => $me->getName(),
                'password' => Hash::make($password)
            ]);

            $user = $newUser;
        }

        $token = JWTAuth::fromUser($user);

        return response()->json($this->makeSuccessResponse(compact('user','token')),200);
    }

}
