<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Suport\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'user_id'];

    public function groupUsers() {
        return $this->hasMany('App\GroupUser');
    }

    public function isAdmin ($userId) {
        return ($this->user_id == $userId);
    }

    public static function getAll ($name) {
        return self::where('name', 'like',  "%{$name}%")->paginate(10);
    }

}
