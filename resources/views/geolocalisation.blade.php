<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de localisation</title>
</head>
<body>
    <h1>Demande de localisation</h1>
    <form action="  ">
        <input type="hidden" name="latitude" value="latitude">
        <input type="hidden" name="longitude" value="longitude">
        <button onclick="getLocation()">Obtenir ma position</button>
    </form>
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

            fetch('/save-location', {
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
                  console.log(data);
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
<script>
    function updateLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                fetch('/update-location', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: lat,
                        longitude: lon
                    })
                }).then(response => response.json())
                  .then(data => console.log('Location updated:', data))
                  .catch(error => console.error('Error updating location:', error));
            });
        } else {
            console.log('Geolocation is not supported by this browser.');
        }
    }
</script>


</body>
</html>
