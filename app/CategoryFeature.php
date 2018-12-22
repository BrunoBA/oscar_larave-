<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryFeature extends Model {
     //
     protected $table = 'category_feature';

     public function feature() {
         return $this->hasOne('App\Feature', 'id', 'feature_id');
     }

     public function category() {
          return $this->hasOne('App\Category', 'id', 'category_id');
     }

     public static function getIdByFeatureAndCategory ($featureId, $categoryId) {
          $categoryFeature = self::select('id')
               ->where('feature_id', $featureId)
               ->where('category_id', $categoryId)
               ->first();
          return $categoryFeature->id;
    }
}
