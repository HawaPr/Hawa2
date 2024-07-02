<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class userLocation extends Model
{
    protected $fillable = ['user_id', 'latitude', 'longitude'];

    public static function findNearby($latitude, $longitude, $distance = 10)
    {
        $query = "SELECT id, user_id, ( 6371 * acos( cos( radians(?) ) *
                  cos( radians( latitude ) )
                  * cos( radians( longitude ) - radians(?)
                  ) + sin( radians(?) ) *
                  sin( radians( latitude ) ) )
                ) AS distance
                FROM user_locations
                HAVING distance < ?
                ORDER BY distance";

        return DB::select($query, [$latitude, $longitude, $latitude, $distance]);
    }
     
}
