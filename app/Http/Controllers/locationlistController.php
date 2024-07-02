<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\userLocation;
use Illuminate\Http\Request;
use Twilio\Rest\Chat\V1\Service\UserList;

class LocationlistController extends Controller
{
    public function locationlist()
    {
        $locationlist = User_locations::all(); // Récupérer toutes les entrées de la table UserLocation

        return view('locationlist', compact('locationlist'));
    }
}
