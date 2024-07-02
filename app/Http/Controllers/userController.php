<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; // Assurez-vous d'importer le modèle User

class UserController extends Controller
{

    public function store(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        UserLocation::create([
            'user_id' => auth()->user()->id,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return response()->json([
            'message' => 'Localisation sauvegardée avec succès !',
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }

 public function updateLocation(Request $request, $id)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        

        // Trouver l'utilisateur par son ID
        $user = User::findOrFail($id);


        // Mettre à jour les champs latitude et longitude
        $user->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['message' => 'Localisation mise à jour avec succès !']);
    }
}


