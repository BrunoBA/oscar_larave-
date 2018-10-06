<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    //
    public function features() {
        return $this->belongsToMany('App\Feature');
    }
}
