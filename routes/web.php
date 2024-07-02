<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\locationlistController;
use App\Http\Controllers\UserController;
use App\Models\userLocation;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/geolocation', function () {
    return view('geolocation');
});

Route::post('/save-location', [LocationController::class, 'store']);


Route::post('/send-alert', [AlertController::class, 'sendAlert'])->middleware('auth');


// Route pour afficher la vue du formulaire
Route::get('/send-alert-form', function () {
    return view('send_alert');
})->middleware('auth');

// Route pour gérer la soumission du formulaire
Route::post('/send-alert', [AlertController::class, 'sendAlert'])->middleware('auth');

Route::put('/users/{id}/update-location', [UserController::class, 'updateLocation']);


// Route::get('/locationlist',function () {
//     return view('locationlist');})->middleware('auth');
    Route::get('/locationlist', [locationlistController::class, 'locationList'])->name('location.list');
    Route::post('/update-location', function (Request $request) {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);
    
        userLocation::updateOrCreate(
            ['user_id' => auth()->id()],
            ['latitude' => $validated['latitude'], 'longitude' => $validated['longitude']]
        );
    
        return response()->json(['status' => 'success']);
    });
    