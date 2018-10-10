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
        dd($user);

    }

}
