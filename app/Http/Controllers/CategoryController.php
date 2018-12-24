<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            return response()->json($this->makeSuccessResponse(Category::all()), 200);
        } catch (Exception $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }        
    }
}
