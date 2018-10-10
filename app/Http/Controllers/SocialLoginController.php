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

        dd($socialUser);

        $token = JWTAuth::fromUser($socialUser);

        return response()->json(compact('token'), 200);

    }

}
