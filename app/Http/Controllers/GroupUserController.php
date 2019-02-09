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
            'users_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($this->makeValidatorResponse($validator->errors()), 400);
        }

        $group = Group::find($group_id);
        $currentUser = JWTAuth::parseToken()->authenticate();

        if ($group == null) {
            return response()->json($this->makeErrorResponse("Invalid Group", 400), 400);
        }
        if (!$group->isAdmin($currentUser->id)) {
            return response()->json($this->makeErrorResponse("You're not admin", 400), 400);
        }

        if (is_array($request->users_id)) {
            $users = $request->users_id;
        } else {
            $users[] = $request->users_id;
        }

        foreach ($users as $user_id) {
            if (GroupUser::checkUserOfGroup($user_id, $group_id)) {
                return response()->json($this->makeErrorResponse("This user is already in this group", 400), 400);
            }
        }

        try {   
            foreach ($users as $user_id) {
                GroupUser::create(
                    [
                        'group_id' => $group_id,
                        'user_id' => $user_id
                    ]
                );
            }

            $groupUser = GroupUser::getUsersFromGroup($group_id);
            
            return response()->json($this->makeSuccessResponse($groupUser), 200);

        } catch (Execption $e) {
            return response()->json($this->makeErrorResponse($e->getMessage(), $e->getStatusCode()), 400);
        }
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
