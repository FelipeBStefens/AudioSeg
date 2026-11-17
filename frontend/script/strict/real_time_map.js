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
        layers: [{ id: 'osm', type: 'raster', source: 'osm' }]
    },
    center: [-51.1343, -29.7642],
    zoom: 12,
    minZoom: 3,
    maxZoom: 19
});

const shootingCards = new Map();
const shootingMarkers = new Map();

const container = document.querySelector('.shootings_list');
let updating = false;

function create_shooting_card(shot, index) {

    const card = document.createElement('div');
    card.className = 'shooting_card';

    card.innerHTML = `
        <button class="shooting_header"
                type="button"
                aria-expanded="false">

            <div class="shooting_info">
                <span class="material-symbols-rounded">
                    crisis_alert
                </span>

                <div class="shooting_main_info">
                    <span class="shooting_id"></span>
                    <span class="shooting_location"></span>
                </div>
            </div>

            <span class="material-symbols-rounded shooting_arrow">
                keyboard_arrow_down
            </span>
        </button>

        <div class="shooting_details">

            <div class="buttons_container">
                <form action="/../../server/strict/make_it_public_service.php" method="POST">

                    <input class="public_gunshot" type="hidden" name="public_gunshot">

                    <button class="make_public button_card" type="submit">
                        Make it public
                    </button>
                </form>

                <button class="go_there button_card" type="submit" onclick="make_route()">
                    Go there
                </button>
            </div>

            <div class="detail_item">
                <span class="detail_label">DATE AND TIME</span>
                <span class="detail_value date"></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">CARTESIAN COORDENATE</span>
                <span class="detail_value coordinates"></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">GUN TYPE</span>
                <span class="detail_value gun"></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">STREET</span>
                <span class="detail_value street"></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">CITY</span>
                <span class="detail_value city"></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">COUNTRY</span>
                <span class="detail_value country"></span>
            </div>

        </div>
    `;

    update_shooting_card(card, shot, index);
    return card;
}

function update_shooting_card(card, shot, index) {

    const setText = (selector, value) => {
        card.querySelector(selector).textContent = value ?? '';
    };

    card.dataset.lng = shot.shot_longitude;
    card.dataset.lat = shot.shot_latitude;

    const bt = card.querySelector(".make_public");

    if (shot.public_shot == false) {
        card.querySelector(".public_gunshot").value = shot.id_gunshot;
    } 
    else {
        bt.classList.add("disabled_bt");
    }

    setText('.shooting_location', `${shot.shot_city}, ${shot.shot_state}, ${shot.shot_country}`);
    setText('.shooting_id', `Incident ${index}`);
    setText('.date', shot.date_gunshot);
    setText('.coordinates', `${shot.shot_latitude}, ${shot.shot_longitude}`);
    setText('.gun', `${shot.type_gun}: ${shot.accuracy}%`);
    setText('.street', `${shot.shot_street}, ${shot.shot_neighborhood}`);
    setText('.city', `${shot.shot_city}, ${shot.shot_state}`);
    setText('.country', shot.shot_country);
}

function update_shooting_marker(id, shot) {

    const coordinates = [
        Number(shot.shot_longitude),
        Number(shot.shot_latitude)
    ];

    if (!coordinates.every(Number.isFinite)) {
        return;
    }

    const existingMarker = shootingMarkers.get(id);

    if (existingMarker) {
        existingMarker.setLngLat(coordinates);
    } 
    else {
        const marker = new maplibregl.Marker({color: 'red'}).setLngLat(coordinates).addTo(map);
        shootingMarkers.set(id, marker);
    }
}

function synchronize_shootings(shots) {

    const currentIds = new Set();
    let index = 1;

    shots.forEach(shot => {

        const id = String(shot.id_gunshot);
        currentIds.add(id);

        let card = shootingCards.get(id);

        if (!card) {

            card = create_shooting_card(shot, index);
            shootingCards.set(id, card);
            container.appendChild(card);
        } 
        else {
            update_shooting_card(card, shot, index);
        }

        update_shooting_marker(id, shot);
        index++;
    });

    for (const [id, card] of shootingCards) {

        if (!currentIds.has(id)) {
            card.remove();
            shootingCards.delete(id);
        }
    }

    for (const [id, marker] of shootingMarkers) {

        if (!currentIds.has(id)) {
            marker.remove();
            shootingMarkers.delete(id);
        }
    }
}

container.addEventListener('click', event => {

    const header = event.target.closest('.shooting_header');

    if (!header || !container.contains(header)) {
        return;
    }

    const card = header.closest('.shooting_card');
    const isExpanded = card.classList.contains('expanded');

    container.querySelectorAll('.shooting_card.expanded').forEach(otherCard => {

        otherCard.classList.remove('expanded');
        otherCard.querySelector('.shooting_header').setAttribute('aria-expanded', 'false');
    });

    if (!isExpanded) {

        card.classList.add('expanded');
        header.setAttribute('aria-expanded', 'true');

        map.flyTo({
            center: [Number(card.dataset.lng), Number(card.dataset.lat)],
            zoom: 16,
            speed: 1.2,
            curve: 1.4,
            essential: true
        });
    }
});

async function update_shootings() {

    if (updating) return;

    updating = true;

    try {

        const response = await fetch('../../server/strict/real_time_service.php');

        if (!response.ok) {
            throw new Error('Server Error');
        }

        const data = await response.json();
        synchronize_shootings(data.shootings);
    } 
    catch (error) {
        console.error(error);
    } 
    finally {
        updating = false;
    }
}

map.on('load', () => {
    update_shootings();
    setInterval(update_shootings, 5000);
});