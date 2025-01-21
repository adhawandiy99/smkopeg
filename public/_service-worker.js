// To clear cache on devices, always increase APP_VER number after making changes.
// The app will serve fresh content right away or after 2-3 refreshes (open / close)
var APP_NAME = 'SMpro';
var APP_VER = '1.5';
var CACHE_NAME = APP_NAME + '-' + APP_VER;

// Files required to make this app work offline.
// Add all files you want to view offline below.
// Leave REQUIRED_FILES = [] to disable offline.
var REQUIRED_FILES = [
	// Styles
	'/mobile/styles/style.css',
	'/mobile/styles/bootstrap.css',
	// Scripts
	'/mobile/scripts/custom.js',
	'/mobile/scripts/bootstrap.min.js',
	// 'https://code.jquery.com/jquery-3.7.1.js',
	// Plugins
	// Fonts
	'/mobile/fonts/bootstrap-icons.css',
	'/mobile/fonts/bootstrap-icons.woff',
	'/mobile/fonts/bootstrap-icons.woff2',
	// Images
	'/mobile/images/empty.png',
];

// Service Worker Diagnostic. Set true to get console logs.
var APP_DIAG = false;

//Service Worker Function Below.
self.addEventListener('install', function(event) {
	event.waitUntil(
		caches.open(CACHE_NAME)
		.then(function(cache) {
			//Adding files to cache
			return cache.addAll(REQUIRED_FILES);
		}).catch(function(error) {
			//Output error if file locations are incorrect
			if(APP_DIAG){console.log('Service Worker Cache: Error Check REQUIRED_FILES array in _service-worker.js - files are missing or path to files is incorrectly written -  ' + error);}
		})
		.then(function() {
			//Install SW if everything is ok
			return self.skipWaiting();
		})
		.then(function(){
			if(APP_DIAG){console.log('Service Worker: Cache is OK');}
		})
	);
	if(APP_DIAG){console.log('Service Worker: Installed');}
});

self.addEventListener('fetch', function(event) {
	event.respondWith(
		//Fetch Data from cache if offline
		caches.match(event.request)
			.then(function(response) {
				if (response) {return response;}
				return fetch(event.request);
			}
		)
	);
	if(APP_DIAG){console.log('Service Worker: Fetching '+APP_NAME+'-'+APP_VER+' files from Cache');}
});

self.addEventListener('activate', function(event) {
	event.waitUntil(self.clients.claim());
	event.waitUntil(
		//Check cache number, clear all assets and re-add if cache number changed
		caches.keys().then(cacheNames => {
			return Promise.all(
				cacheNames
					.filter(cacheName => (cacheName.startsWith(APP_NAME + "-")))
					.filter(cacheName => (cacheName !== CACHE_NAME))
					.map(cacheName => caches.delete(cacheName))
			);
		})
	);
	if(APP_DIAG){console.log('Service Worker: Activated')}
});



// Listen for messages from the main script
self.addEventListener('message', (event) => {
    if (event.data.type === 'SEND_LOCATION') {
        const { latitude, longitude, id_user } = event.data;

        // You can perform the fetch request here
        console.log([id_user, latitude, longitude]);
        sendLocationToServer(id_user, latitude, longitude);
    }
});

// Function to send location to the server
async function sendLocationToServer(id_user, latitude, longitude) {
    await fetch('/api/location', {
        method: 'POST',
        body: JSON.stringify({ id_user, latitude, longitude }),
        headers: {
            'Content-Type': 'application/json',
        },
    });
}

// Background sync event
self.addEventListener('sync', (event) => {
    if (event.tag === 'sendLocation') {
        event.waitUntil(sendLocation());
    }
});

// Function to send location when triggered by Background Sync
async function sendLocation() {
    // Get stored location (you could implement your own logic here)
    const lastLocation = await getLastStoredLocation(); // You'll need to implement this

    if (lastLocation) {
        const { latitude, longitude, id_user } = lastLocation;

        // Send location to server
        await sendLocationToServer(id_user, latitude, longitude);
    }
}

// Function to retrieve last stored location
async function getLastStoredLocation() {
    // This can vary based on how you store the location
    const cache = await caches.open('location-cache');
    const response = await cache.match('lastLocation');
    return response ? response.json() : null;
}