import * as maplibregl from 'https://unpkg.com/maplibre-gl@6.16.0/dist/maplibre-gl.mjs';

import { initialize_map } from '../map.js';


const {map} = initialize_map();
let shot_quantity = 0;

const shootingCards = document.querySelectorAll('.shooting_card');

shootingCards.forEach(card => {

    shot_quantity++;
    const longitude = Number(card.dataset.lng);
    const latitude = Number(card.dataset.lat);

    if (!Number.isFinite(longitude) || !Number.isFinite(latitude)) {
        return;
    }

    new maplibregl.Marker({color: 'red'}).setLngLat([longitude, latitude]).addTo(map);
});

shootingCards.forEach(card => {

    const header = card.querySelector('.shooting_header');

    header.addEventListener('click', () => {

        const isExpanded = card.classList.contains('expanded');

        shootingCards.forEach(otherCard => {
            otherCard.classList.remove('expanded');
            otherCard.querySelector('.shooting_header').setAttribute('aria-expanded', 'false');
        });

        if (!isExpanded) {

            card.classList.add('expanded');
            header.setAttribute('aria-expanded', 'true');

            const longitude = Number(card.dataset.lng);
            const latitude = Number(card.dataset.lat);

            map.flyTo({center: [longitude, latitude], zoom: 16, speed: 1.2, curve: 1.4, essential: true});
        }
    });
});

document.getElementById('quantity').textContent = shot_quantity;