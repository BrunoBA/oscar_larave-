<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Socialite;

class SocialLoginController extends Controller {


    public function show($driver) {
        return Socialite::driver($driver)->redirect();
    }

    public function facebook () {
        $user = Socialite::driver('facebook')->user();
        $token = JWTAuth::fromUser($user);

        $socialUser = User::where('email', $user->email)->first();

        dd($socialUser);

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

}
