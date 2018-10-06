<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bet extends Model {
    
    use SoftDeletes;

    public static function deleteAllBetsIdByCategoryAndUserId ($categoryId, $userId) {
        $ids = self::getAllBetsIdByCategoryAndUserId($categoryId, $userId);

        return self::whereIn('id', $ids)->delete();
    }

    public static function getAllBetsIdByCategoryAndUserId ($categoryId, $userId) {
        $betsIds = self::select('bets.id')
        ->join('category_feature', 'bets.category_features_id', '=', 'category_feature.id')
        ->where('category_feature.category_id', $categoryId)
        ->where('bets.user_id', $userId)
        ->whereNull('bets.deleted_at')
        ->get()
        ->toArray();

        if (count($betsIds) == 0) {
            return [];
        }

        $ids = array_map( function($item) {
            return $item['id'];
        }, $betsIds);

        return $ids;
    }
}
