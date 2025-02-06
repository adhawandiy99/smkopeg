@extends('mobile')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/leaflet.fullscreen.css" />
@endsection

@section('tittle', 'Survey Layanan')

@section('content')

<div id="map" style="height: 700px;" class="mb-3"></div>
@endsection

@section('offcanvas')
@endsection
@section('js')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Leaflet.fullscreen.min.js"></script>

<script type="text/javascript">
  $(document).ready(function () {
    let map, marker, markerHomepass;
    map = L.map('map', {
        fullscreenControl: true, // Enable fullscreen button
        fullscreenControlOptions: { 
            position: 'topleft' 
        }
    });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          // Get the user's current location
          var lat = position.coords.latitude;
          var lon = position.coords.longitude;
          // Center the map on the user's location
          map.setView([lat, lon], 13);
        }, function(error) {
          // Fallback if the user's location is not available
          alert("Geolocation failed: " + error.message);
          // Optionally set a default marker or leave it null
          map.setView([-3.319234, 114.589323], 13); // Example: Default to London
        });
    } else {
      alert("Geolocation is not supported by this browser.");
    }
    // Listen for fullscreen toggle
    map.on('enterFullscreen', function(){
        console.log('Map entered fullscreen mode');
    });

    map.on('exitFullscreen', function(){
        console.log('Map exited fullscreen mode');
    });
  });
</script>
@endsection