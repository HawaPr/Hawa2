<!-- resources/views/send_alert.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Envoyer une alerte</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Optionnel, si vous utilisez un CSS -->
</head>
<body>
    <div class="container">
        <h1>Envoyer une alerte</h1>
        <form id="alertForm">
            <label for="latitude">Latitude:</label>
            <input type="text" id="latitude" name="latitude" required>
            <br>
            <label for="longitude">Longitude:</label>
            <input type="text" id="longitude" name="longitude" required>
            <br>
            <button type="submit">Envoyer une alerte</button>
        </form>
        <h1 href="url('localist')">recevoir une reponse</h1>
    </div>

    <script>
        document.getElementById('alertForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const latitude = document.getElementById('latitude').value;
            const longitude = document.getElementById('longitude').value;

            fetch('/send-alert', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ latitude, longitude })
            })
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error('Erreur:', error));
        });
    </script>
</body>
</html>
