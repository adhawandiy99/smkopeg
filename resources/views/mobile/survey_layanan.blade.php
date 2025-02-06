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

    let allMarkers = []; // Store all markers from the API
    let activeMarkers = []; // Store active markers to remove later

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            let lat = position.coords.latitude;
            let lon = position.coords.longitude;
            map.setView([lat, lon], 13);
        }, function(error) {
            alert("Geolocation failed: " + error.message);
            map.setView([-3.319234, 114.589323], 13); // Default fallback
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
            url: "/get_markers",
            type: "GET",
            dataType: "json",
            success: function(response) {
                allMarkers = response.markers;
                console.log(allMarkers);
                renderVisibleMarkers();
            },
            error: function(xhr) {
                console.error("Failed to load markers:", xhr);
            }
        });
    }
    
    fetchMarkers();

    // Render only markers inside the displayed map view
    function renderVisibleMarkers() {
        // Remove existing markers
        activeMarkers.forEach(marker => map.removeLayer(marker));
        activeMarkers = [];

        let bounds = map.getBounds();

        allMarkers.forEach(function(markerData) {
            let lat = parseFloat(markerData.lat);
            let lon = parseFloat(markerData.lon);

            if (!isValidCoordinate(lat, lon)) {
                return;
            }

            let markerLatLng = L.latLng(lat, lon);

            if (bounds.contains(markerLatLng)) {
                let customIcon = L.icon({
                    iconUrl: markerData.type === 'ODP' ? 
                        `/images/location_blue.png` : 
                        `/images/location_home.png`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                });

                let marker = L.marker(markerLatLng, { icon: customIcon })
                    .bindPopup(`<b>${markerData.type}</b><br>${markerData.name}`);
                
                marker.addTo(map);
                activeMarkers.push(marker);
            }
        });
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