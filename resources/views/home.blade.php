

@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de localisation</title>
    <link rel="stylesheet" href="{{asset('style.css')}}">
</head>
<body>
<div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
    <h1>Demande de localisation</h1>
    <a href="{{ url('locationlist') }}" class="btn btn-primary">Recevoir une réponse</a>

    <button onclick="getLocation()">LAncer une alerte</button>
    <div id="location"></div>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                document.getElementById("location").innerHTML = "La géolocalisation n'est pas supportée par ce navigateur.";
            }
        }

        function showPosition(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            document.getElementById("location").innerHTML = "Latitude: " + latitude + "<br>Longitude: " + longitude;

            fetch('/send-alert', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    latitude: latitude,
                    longitude: longitude
                })
            }).then(response => response.json())
              .then(data => {
                console.log(data['success']);
                console.log(data['users']);
                if (data['success']) {
                    document.getElementById("location").innerHTML = "Notifications envoyées aux utilisateurs à proximité\n " + data['users'];
                }
                  console.log("Notifications envoyées aux utilisateurs à proximité");
              }).catch(e => {
                console.log(é);
              });
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    document.getElementById("location").innerHTML = "L'utilisateur a refusé la demande de géolocalisation."
                    break;
                case error.POSITION_UNAVAILABLE:
                    document.getElementById("location").innerHTML = "Les informations de localisation ne sont pas disponibles."
                    break;
                case error.TIMEOUT:
                    document.getElementById("location").innerHTML = "La demande de localisation a expiré."
                    break;
                case error.UNKNOWN_ERROR:
                    document.getElementById("location").innerHTML = "Une erreur inconnue s'est produite."
                    break;
            }
        }
    </script>
</body>
</html>

@endsection