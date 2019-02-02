<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bet;
use App\Watch;
use JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $searchName = ($request->q != null) ? $request->q : '';
            $users = User::getAll($searchName);
        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }

        return response()->json($this->makeSuccessResponse($users), 200);
    }

    public function show ($user_id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = (User::ME == $user_id) ? $user->id : $user_id;

        try {
            $resonse['bets'] = [];
            $resonse['user'] = [];
            $resonse['watches'] = [];

            $bets = Bet::getAllBetsByUser($userId);      
            $user = User::find($userId);
            $watches = Watch::getAllWatchesByUser($userId);

            $resonse['bets'] = $bets;
            $resonse['user'] = $user;
            $resonse['watches'] = $watches;

        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }

        return response()->json($this->makeSuccessResponse($resonse), 200);
    }
}
