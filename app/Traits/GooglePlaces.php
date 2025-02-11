<?php

namespace App\Traits;

use Exception;
use GooglePlace\Request;
use GooglePlace\Services\Place;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait GooglePlaces {
    function getPlaces($inPID): Place
    {
        Request::$api_key = config('maps.maps_api');
        $place = new Place([
            'placeid' => $inPID
        ]);
        $place->get();
   //     ray($place);
        return $place;
    }

    function getDescription($inPID)
    {
        try {
            $response = Http::get("https://maps.googleapis.com/maps/api/place/details/json?place_id=$inPID&key=".config('maps.maps_api'));
            $arr = json_decode($response->body(), true);
            if (array_key_exists('editorial_summary', $arr['result'])) {
                return $arr['result']['editorial_summary']['overview'];
            } else {
                return null;
            }
        } catch (Exception $e) {
            Log::error('Description Retrieval Error: '.$e->getMessage());
            return null;
        }
    }
    public function getRating()
    {
        return isset($this->attributes['rating']) ? $this->attributes['rating'] : false;
    }
    public function getUser_ratings_total()
    {
        return isset($this->attributes['user_ratings_total']) ? $this->attributes['user_ratings_total'] : false;
    }
}
