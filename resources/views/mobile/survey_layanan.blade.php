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
    let map, markersCluster, allMarkers = [], activeMarkers = [];

    // Initialize map with default view
    map = L.map('map', {
        fullscreenControl: true,
        fullscreenControlOptions: { position: 'topleft' }
    }).setView([-3.319234, 114.589323], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    markersCluster = L.markerClusterGroup();
    map.addLayer(markersCluster);

    // Get max zoom level from the tile layer
    let maxZoom = 18;

    function fetchMarkers() {
        $.ajax({
            url: "/get_markers",
            type: "GET",
            dataType: "json",
            success: function(response) {
                allMarkers = response.markers;
                console.log("Markers loaded:", allMarkers);
                renderVisibleMarkers();
            },
            error: function(xhr) {
                console.error("Failed to load markers:", xhr);
            }
        });
    }

    function renderVisibleMarkers() {
        if (!map || !map.getBounds) return;

        let bounds = map.getBounds();
        let currentZoom = map.getZoom();

        // Clear previous markers
        markersCluster.clearLayers();
        activeMarkers.forEach(marker => map.removeLayer(marker));
        activeMarkers = [];

        allMarkers.forEach(function(markerData) {
            let lat = parseFloat(markerData.lat);
            let lon = parseFloat(markerData.lon);

            if (!isValidCoordinate(lat, lon)) return;

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

                if (currentZoom >= maxZoom) {
                    // At max zoom, add individual markers to the map
                    marker.addTo(map);
                    activeMarkers.push(marker);
                } else {
                    // Otherwise, use marker clustering
                    markersCluster.addLayer(marker);
                }
            }
        });

        // Only add clustering if not at max zoom
        if (currentZoom < maxZoom) {
            map.addLayer(markersCluster);
        }
    }

    function isValidCoordinate(lat, lon) {
        return !isNaN(lat) && !isNaN(lon) &&
               lat >= -90 && lat <= 90 &&
               lon >= -180 && lon <= 180;
    }

    // Load markers when the map is ready
    map.whenReady(fetchMarkers);

    // Update markers on zoom and movement
    map.on('moveend zoomend', function() {
        renderVisibleMarkers();
    });
});

</script>
@endsection