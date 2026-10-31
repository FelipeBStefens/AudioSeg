import * as maplibregl from 'https://unpkg.com/maplibre-gl@6.16.0/dist/maplibre-gl.mjs';

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
    
    center: [-51.1343, -29.7642],
    zoom: 12,
    minZoom: 3,
    maxZoom: 19
});

const shootingCards = document.querySelectorAll(".shooting_card");

shootingCards.forEach(card => {

    const header = card.querySelector(".shooting_header");

    header.addEventListener("click", () => {

        const isExpanded = card.classList.contains("expanded");

        shootingCards.forEach(otherCard => {
            otherCard.classList.remove("expanded");
            otherCard.querySelector(".shooting_header").setAttribute("aria-expanded", "false");
        });

        if (!isExpanded) {

            card.classList.add("expanded");
            header.setAttribute("aria-expanded", "true");

            const longitude = Number(card.dataset.lng);
            const latitude = Number(card.dataset.lat);

            map.flyTo({center: [longitude, latitude], zoom: 16, speed: 1.2, curve: 1.4, essential: true});
        }
    });
});