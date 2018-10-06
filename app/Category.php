<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    //
    
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function features() {
        return $this->belongsToMany('App\Feature');
    }
}
