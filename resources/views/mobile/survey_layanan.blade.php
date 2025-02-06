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
    let map, markersCluster;
    map = L.map('map', {
        fullscreenControl: true, // Enable fullscreen button
        fullscreenControlOptions: { 
            position: 'topleft' 
        }
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    markersCluster = L.markerClusterGroup(); // Create a cluster group for markers
    let allMarkers = []; // Store all markers from the API

    // Use geolocation to center the map on the user's current location
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
            map.setView([-3.319234, 114.589323], 13); // Example: Default to a location
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }

    // Fetch markers from the server
    function fetchMarkers(bounds) {
        $.ajax({
            url: "/get_markers", // Adjust your API route
            type: "GET",
            dataType: "json",
            data: {
                // Send map bounds to the server if needed for filtering markers
                minLat: bounds.getSouth(),
                maxLat: bounds.getNorth(),
                minLon: bounds.getWest(),
                maxLon: bounds.getEast()
            },
            success: function(response) {
                allMarkers = response.markers; // Store the markers
                renderVisibleMarkers(); // Render only visible markers
            },
            error: function(xhr) {
                console.error("Failed to load markers:", xhr);
            }
        });
    }

    // Initial fetch when page loads
    map.on('load', function () {
        fetchMarkers(map.getBounds()); // Get markers for initial view
    });

    // Re-fetch markers when map is moved or zoomed
    map.on('moveend', function() {
        fetchMarkers(map.getBounds()); // Fetch new markers when the map moves
    });

    // Render only markers inside the displayed map view
    function renderVisibleMarkers() {
        markersCluster.clearLayers(); // Clear previous markers from the cluster

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
                let customIcon;
                if (markerData.type === 'ODP') {
                    customIcon = L.icon({
                        iconUrl: `/images/location_blue.png`, // Path to your custom ODP icon
                        iconSize: [32, 32],  // Adjust icon size as needed
                        iconAnchor: [16, 32],  // Anchor point of the icon
                        popupAnchor: [0, -32]  // Position of popup relative to the icon
                    });
                } else {
                    customIcon = L.icon({
                        iconUrl: `/images/location_home.png`,  // Path to your custom Homepass icon
                        iconSize: [32, 32],  // Adjust icon size as needed
                        iconAnchor: [16, 32],  // Anchor point of the icon
                        popupAnchor: [0, -32]  // Position of popup relative to the icon
                    });
                }

                // Create the marker with custom icon and bind popup
                let marker = L.marker(markerLatLng, { icon: customIcon })
                    .bindPopup(`<b>${markerData.type}</b><br>${markerData.name}`);
                
                markersCluster.addLayer(marker); // Add marker to cluster
            }
        });

        // Add marker cluster layer to the map
        map.addLayer(markersCluster);
    }

    // Coordinate validation function
    function isValidCoordinate(lat, lon) {
        return !isNaN(lat) && !isNaN(lon) &&
               lat >= -90 && lat <= 90 &&
               lon >= -180 && lon <= 180;
    }

});
</script>
@endsection