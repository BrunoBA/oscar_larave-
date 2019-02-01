<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function isAdmin ($userId) {
        return ($this->user_id == $userId);
    }
}
