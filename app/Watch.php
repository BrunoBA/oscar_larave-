<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    protected $fillable = ['user_id', 'feature_id'];
    protected $hidden = ['user_id', 'feature_id', 'created_at', 'updated_at', 'deleted_at'];

    public function feature() {
        return $this->hasOne('App\Feature', 'id', 'feature_id');
    }

    public static function getAllWatchesByUser ($userId) {
        return self::with(['feature', 'feature.picture'])->where('user_id', $userId)->get();
    }

    public static function insertOrDeleteWatchedMovie ($featureId, $userId) {
        $paramns = [
            'feature_id' => $featureId,
            'user_id' => $userId
        ];
        
        if (self::checkIfWatched($featureId, $userId)) {
            self::where($paramns)->delete();
            $return = "Movie Deleted";
        } else {
            Watch::create($paramns);
            $return = "Movie Inserted";
        }
        return $return;
    }

    public static function checkIfWatched ($featureId, $userId) {
        $watched = self::where(
            [
                'feature_id' => $featureId,
                'user_id' => $userId
            ]
        )->first();

        return $watched != null;
    }
}
