<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $fillable = ['group_id', 'user_id'];

    public static function checkUserOfGroup ($userId, $groupId) {
        return (self::where('group_id', $groupId)
        ->where('user_id', $userId)
        ->whereNull('deleted_at')
        ->count() > 0);
    }
}
