<?php
    function create_shoot() {
?>
    <div class="shooting_card" data-lng="-51.1343" data-lat="-29.7642">

        <button class="shooting_header" type="button" aria-expanded="false">

            <div class="shooting_info">
                <span class="material-symbols-rounded">crisis_alert</span>

                <div class="shooting_main_info">
                    <span class="shooting_id">Incident 24</span>
                    <span class="shooting_location">São Leopoldo, RS</span>
                </div>
            </div>

            <span class="material-symbols-rounded shooting_arrow">keyboard_arrow_down</span>
        </button>

        <div class="shooting_details">

            <div class="detail_item">
                <span class="detail_label">DATE AND TIME</span>
                <span class="detail_value">30/10/2026 — 14:32:18</span>
            </div>

            <div class="detail_item">
                <span class="detail_label">CITY</span>
                <span class="detail_value">São Leopoldo</span>
            </div>

            <div class="detail_item">
                <span class="detail_label">STATE</span>
                <span class="detail_value">Rio Grande do Sul</span>
            </div>

            <div class="detail_item">
                <span class="detail_label">INCIDENT TYPE</span>
                <span class="detail_value">Multiple gunshots</span>
            </div>
        </div>
    </div>
<?php
    };
?>