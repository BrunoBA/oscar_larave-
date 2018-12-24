<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use App\Watch;
use App\Feature;

class WatchController extends Controller
{
    public function show (Request $request) {
        $user = JWTAuth::parseToken()->authenticate();

        $userId = ($request->user_id != null) ? $request->user_id : $user->id;
        $watches = Watch::getAllWatchesByUser($userId);      
        return response()->json($this->makeSuccessResponse($watches), 200);
    }

    public function store (Request $request) {
        $user = JWTAuth::parseToken()->authenticate();

        $feature = Feature::find($request->feature_id);
        if ($feature == null || !$feature->isMovie()) {
            return response()->json($this->makeErrorResponse(400, "Invalid Movie!"), 400);
        }

        $watches = Watch::insertOrDeleteWatchedMovie($feature->id, $user->id);      
        return response()->json($this->makeSuccessResponse($watches), 200);
    }
}
