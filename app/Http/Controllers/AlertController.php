<?php

namespace App\Http\Controllers;

use App\Models\UserLocation;
use App\Models\User;
use Twilio\Rest\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function sendAlert(Request $request)
    {
        $latitude = $request->input("latitude");
        $longitude = $request->input("longitude");
        $location = UserLocation::create([
            'user_id' => auth()->user()->id,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        $message = "Besoin de secours à proximité ! Veuillez vous rendre à cette localisation : https://maps.google.com/?q={$latitude},{$longitude}";

        // Trouver les utilisateurs à proximité
        $nearbyUsers = UserLocation::findNearby($location->latitude, $location->longitude, 10); // 10 est le rayon en km

        // Envoyer des notifications aux utilisateurs trouvés
        foreach ($nearbyUsers as $location) {
            $user = User::find($location->user_id);
            if ($user) {
                $this->sendSMS($user->phone_number, $message);
                // $user->notify(new NearbyAlert('Besoin de secours à proximité !'));
            }
        }
        return response()->json(["success" => true, 'users'=> $nearbyUsers]);
    }

    function sendSMS($phoneNumber, $message)
{
    $account_sid = getenv("TWILIO_SID");
    $auth_token = getenv("TWILIO_AUTH_TOKEN");
    $twilio_number = getenv("TWILIO_NUMBER");
    $client = new Client($account_sid, $auth_token);
    $client->messages->create($phoneNumber, 
            ['from' => $twilio_number, 'body' => $message] );
}
}
