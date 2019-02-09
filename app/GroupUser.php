<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupUser extends Model
{
    use SoftDeletes;

    protected $fillable = ['group_id', 'user_id'];

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public static function checkUserOfGroup ($userId, $groupId) {
        return (self::where('group_id', $groupId)
        ->where('user_id', $userId)
        ->whereNull('deleted_at')
        ->count() > 0);
    }

    public static function getUsersFromGroup ($groupId) {
        return self::select(['users.id', 'name'])
            ->where('group_id', $groupId)
            ->whereNull('deleted_at')
            ->whereNull('group_users.deleted_at')
            ->join('users', 'users.id', 'group_users.user_id')
            ->get();
    }

    public static function getGroupsByUser ($userId) {
        return self::select(['groups.name', 'groups.id'])
            ->join('groups', 'groups.id', 'group_users.group_id')
            ->where('group_users.user_id', $userId)
            ->whereNull('group_users.deleted_at')
            ->whereNull('groups.deleted_at')
            ->get();
    }
}
