import * as maplibregl from 'https://unpkg.com/maplibre-gl@6.16.0/dist/maplibre-gl.mjs';

export function initialize_map() {

    const map = new maplibregl.Map({

        container: 'map',
        style: {
            version: 8,
            sources: {
                osm: {
                    type: 'raster',
                    tiles: ['https://tile.openstreetmap.org/{z}/{x}/{y}.png'],
                    tileSize: 256,
                    attribution: '© OpenStreetMap contributors'
                }
            },
            layers: [{id: 'osm', type: 'raster', source: 'osm'}]
        },
        center: [-51.1562030, -29.8153669],
        zoom: 12,
        minZoom: 3,
        maxZoom: 19
    });

    let userCoordinates = null;
    let userMarker = null;
    let watchId = null;
    let hasCenteredOnUser = false;

    function update_user_position(position) {

        const coordinates = [position.coords.longitude, position.coords.latitude];
        userCoordinates = coordinates;

        if (!userMarker) {

            const dot = document.createElement('div');
            dot.className = 'user_location_dot';
            userMarker = new maplibregl.Marker({element: dot, anchor: 'center'}).setLngLat(coordinates).addTo(map);
        } 
        else {
            userMarker.setLngLat(coordinates);
        }

        if (!hasCenteredOnUser) {

            map.flyTo({center: coordinates, zoom: 14, essential: true});
            hasCenteredOnUser = true;
        }
    }

    function start_user_location() {

        if (!navigator.geolocation) {

            console.error('Geolocation is not supported by this browser.');
            return;
        }

        if (watchId !== null) {
            return;
        }

        watchId = navigator.geolocation.watchPosition(
            update_user_position,
            error => {
                console.error(error.message);
                watchId = null;
            },
            {
                enableHighAccuracy: true,
                maximumAge: 3000,
                timeout: 10000
            }
        );
    }

    function stop_user_location() {

        if (watchId !== null) {
            navigator.geolocation.clearWatch(watchId);
            watchId = null;
        }
    }    

    map.once('load', () => {
        start_user_location();
    });

    return {
        map,
        start_user_location,
        stop_user_location, 
        get_user_coordinates: () => userCoordinates
    };
}