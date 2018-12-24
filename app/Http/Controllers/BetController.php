<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use App\Bet;
use App\Category;
use App\CategoryFeature;
use Tymon\JWTAuth\Exceptions\JWTException;

class BetController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $categoryFeature = CategoryFeature::where([
                ['category_id', '=', $request->category_id],
                ['feature_id', '=', $request->feature_id]
            ])->first();
            
            if ($categoryFeature != null) {
                $bet = Bet::deleteAllBetsIdByCategoryAndUserId($request->category_id, $user->id);
                
                if ($request->favorite) {
                    $retornado = Bet::removeAllFavoriteBetsByUser($user->id);
                }

                $newBet = new Bet();
                $newBet->category_features_id = $categoryFeature->id;
                $newBet->user_id = $user->id;
                $newBet->type = Bet::returnType($request->favorite);
                $newBet->save();
            } else {
                $newBet = null;
            }

        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 500);
        }

        return response()->json($this->makeSuccessResponse($newBet), 200);
    }

    public function show (Request $request) {
        $user = JWTAuth::parseToken()->authenticate();

        $userId = ($request->user_id != null) ? $request->user_id : $user->id;
        $bets = Bet::getAllBetsByUser($userId);      
        return response()->json($this->makeSuccessResponse($bets), 200);
    }

}
