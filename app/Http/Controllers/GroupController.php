<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupUser;
use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $groupName = ($request->q != null) ? $request->q : '';
            $groups = Group::getAll($groupName);
        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }

        return response()->json($this->makeSuccessResponse($groups), 200);
    }

    public function show($group_id)
    {
        $group = Group::find($group_id);

        if ($group == null) {
            return response()->json($this->makeErrorResponse("Invalid Group", 400), 400);
        }        

        try {
            $currentUser = JWTAuth::parseToken()->authenticate();

            $group = Group::find($group_id);
            $users = GroupUser::getUsersFromGroup($group_id);

            !$group->isAdmin($currentUser->id);
            $response['group'] = $group;
            $response['users'] = $users;
            $response['isAdmin'] = $group->isAdmin($currentUser->id);

        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }

        return response()->json($this->makeSuccessResponse($response), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($this->makeValidatorResponse($validator->errors()), 400);
        }
        
        try {
            $currentUser = JWTAuth::parseToken()->authenticate();
            
            $group = Group::create(
                [
                    'name' => $request->name,
                    'user_id' => $currentUser->id
                ]
            );

            GroupUser::create([
                'group_id' => $group->id,
                'user_id' => $currentUser->id
            ]);

        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }

        return response()->json($this->makeSuccessResponse($group), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $group_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($this->makeValidatorResponse($validator->errors()), 400);
        }

        $currentUser = JWTAuth::parseToken()->authenticate();
        $group = Group::find($group_id);

        if (!$group->isAdmin($currentUser->id)) {
            return response()->json($this->makeErrorResponse("Error to Update Group", 400), 400);
        }
        
        try {
            $group->fill($request->all())->update();
        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }

        return response()->json($this->makeSuccessResponse($group), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($group_id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $group = Group::find($group_id);

        if (!$group->isAdmin($currentUser->id)) {
            return response()->json($this->makeErrorResponse("Error to Delete Group", 400), 400);
        }
        
        try {
            $group->delete();
        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }

        return response()->json($this->makeSuccessResponse($group), 200);
    }
}
