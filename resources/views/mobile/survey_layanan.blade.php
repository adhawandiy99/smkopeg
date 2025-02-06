@extends('mobile')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
@endsection

@section('tittle', 'Survey Layanan')

@section('content')

<div id="map" style="height: 700px;" class="mb-3"></div>
@endsection

@section('offcanvas')
@endsection
@section('js')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

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
    let markersCluster = L.markerClusterGroup();
    let allMarkers = []; // Store all markers from the API

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
    // Fetch marker data from the server
    function fetchMarkers() {
        $.ajax({
            url: "/get_markers", // Adjust your API route
            type: "GET",
            dataType: "json",
            success: function(response) {
                allMarkers = response.markers; // Store all markers
                console.log(allMarkers);
                renderVisibleMarkers(); // Render only visible markers
            },
            error: function(xhr) {
                console.error("Failed to load markers:", xhr);
            }
        });
    }
    // Fetch markers when the page loads
    fetchMarkers();

    // Render only markers inside the displayed map view
    function renderVisibleMarkers() {
        markersCluster.clearLayers(); // Remove existing markers

        let bounds = map.getBounds(); // Get the visible map boundaries

        allMarkers.forEach(function(markerData) {
            let lat = parseFloat(markerData.lat);
            let lon = parseFloat(markerData.lon);

            // Validate coordinates
            if (!isValidCoordinate(lat, lon)) {
                return; // Skip invalid coordinates
            }

            let markerLatLng = L.latLng(lat, lon);

            // Check if marker is inside the visible map bounds
            if (bounds.contains(markerLatLng)) {
                let marker = L.marker(markerLatLng).bindPopup(`<b>${markerData.type}</b><br>${markerData.name}`);
                markersCluster.addLayer(marker);
            }
        });
        map.addLayer(markersCluster);
    }
    function isValidCoordinate(lat, lon) {
        return !isNaN(lat) && !isNaN(lon) &&
               lat >= -90 && lat <= 90 &&
               lon >= -180 && lon <= 180;
    }
    // Re-render markers when the map is moved
    map.on('moveend', function() {
        renderVisibleMarkers();
    });
  });
</script>
@endsection