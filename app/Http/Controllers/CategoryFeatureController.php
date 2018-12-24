<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\CategoryFeature;
use App\Bet;
use JWTAuth;

class CategoryFeatureController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = JWTAuth::parseToken()->authenticate();
        $categories = Category::with('features', 'features.picture', 'features.feature')->get();
        $currentBets = Bet::getAllBetsIdByUser($user->id);
        $favoriteCategoryFeatureId = Bet::getFavoriteBetByUser($user->id);

        foreach ($categories as $category) {
            foreach ($category->features as &$feature) {
                $categoryFeatureId = CategoryFeature::getIdByFeatureAndCategory($feature->id, $category->id);
                
                $feature['selected'] = in_array($categoryFeatureId, $currentBets);
                $feature['favorite'] = ($favoriteCategoryFeatureId == $categoryFeatureId);
            }
        }

        return response()->json($categories);
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
