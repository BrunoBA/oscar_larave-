<?php

namespace App\Http\Controllers;

use App\GroupUser;
use App\Group;
use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

class GroupUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $group_id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($this->makeValidatorResponse($validator->errors()), 400);
        }

        $group = Group::find($group_id);
        $currentUser = JWTAuth::parseToken()->authenticate();

        if($group == null || 
        !$group->isAdmin($currentUser->id) || 
        GroupUser::checkUserOfGroup($request->user_id, $group_id)) {
            return response()->json($this->makeErrorResponse("Error to Insert User", 400), 400);
        }

        try {   
            $groupUser = GroupUser::create(
                [
                    'group_id' => $group_id,
                    'user_id' => $request->user_id
                ]
            );

        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }

        return response()->json($this->makeSuccessResponse($groupUser), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroupUser  $groupUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupUser $groupUser, $group_id, $user_id)
    {
        $group = Group::find($group_id);
        $currentUser = JWTAuth::parseToken()->authenticate();

        if($group == null || !$group->isAdmin($currentUser->id)) {
            return response()->json($this->makeErrorResponse("Error to Remove User", 400), 400);
        }

        if (!GroupUser::checkUserOfGroup($user_id, $group_id)) {
            return response()->json($this->makeErrorResponse("This User dont belongs to this gruop", 400), 400);
        }

        try {   
            GroupUser::where('user_id', $user_id)
                ->where('group_id', $group_id)
                ->delete();

        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }

        return response()->json($this->makeSuccessResponse("User Deleted"), 200);
    }

    public function show (Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        try {   
            $groupUser = GroupUser::getGroupsByUser($currentUser->id);
            // dd($groupUser);
        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }

        return response()->json($this->makeSuccessResponse($groupUser), 200);
    }
}
