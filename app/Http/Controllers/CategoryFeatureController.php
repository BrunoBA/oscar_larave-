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

        foreach ($categories as $category) {
            foreach ($category->features as &$feature) {
                if (in_array(CategoryFeature::getIdByFeatureAndCategory($feature->id, $category->id), $currentBets)) {
                    $feature['selected'] = true;
                } else {
                    $feature['selected'] = false;
                }
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
