<?php

namespace App\Http\Controllers;

use App\Models\userLocation;
use Illuminate\Support\Facades\Auth;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        // Récupérer la session actuelle
        $session = FacadesDB::table('sessions')->whereId(session()->getId())->first();

        // Créer un client HTTP pour faire une requête à l'API
        $client = new Client();
        try {
            // Appeler l'API pour obtenir les données de géolocalisation
            $response = $client->get("https://ipinfo.io/{$session->ip_address}/geo");
            $body = json_decode($response->getBody()->getContents(), true);
            
            // Diviser les coordonnées de géolocalisation en latitude et longitude
            $loc = explode(',', $body['loc']);

            // Trouver ou créer une entrée pour la localisation de l'utilisateur
            $userLocation = userLocation::updateOrCreate(
                ['user_id' => auth()->user()->id], // Critère de recherche
                ['latitude' => $loc[0], 'longitude' => $loc[1]] // Valeurs à mettre à jour
            );

            return 'Location updated';
        } catch (RequestException $e) {
            return 'Unknown';
        }
    }
}

        // dd($longitude);

        // return response()->json([
        //     'message' => 'Localisation sauvegardée avec succès !',
        //     'latitude' => $latitude,
        //     'longitude' => $longitude,
        // ]);
    
