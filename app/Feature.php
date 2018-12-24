<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model {
    //

    protected $hidden = ['picture_id', 'feature_id', 'created_at', 'updated_at', 'deleted_at'];

    public function picture() {
        return $this->hasOne('App\Picture', 'id', 'picture_id');
    }

    public function feature() {
        return $this->hasOne('App\Feature', 'id', 'feature_id');
    }

    public function isMovie () {
        return ($this->feature_id == null);
    }

    public function isPerson () {
        return ($this->feature_id != null);
    }

}
