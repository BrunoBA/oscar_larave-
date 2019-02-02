<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\CategoryFeature;
use App\Bet;
use App\Watch;
use JWTAuth;

class CategoryFeatureController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        try {

            $user = JWTAuth::parseToken()->authenticate();
            $categories = Category::with('features', 'features.picture', 'features.feature')->get();
            $currentBets = Bet::getAllBetsIdByUser($user->id);
            $favoriteCategoryFeatureId = Bet::getFavoriteBetByUser($user->id);
    
            foreach ($categories as $category) {
                foreach ($category->features as &$feature) {
                    $categoryFeatureId = CategoryFeature::getIdByFeatureAndCategory($feature->id, $category->id);
                    
                    $feature['selected'] = in_array($categoryFeatureId, $currentBets);
                    $feature['favorite'] = ($favoriteCategoryFeatureId == $categoryFeatureId);
                    $feature['watched'] = Watch::checkIfWatched($feature->id, $user->id);
                }
            }

            return response()->json($this->makeSuccessResponse($categories), 200);
        } catch (Exception $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }        
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

}
