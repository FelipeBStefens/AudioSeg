<?php
    function create_shoot(int $index, array $shot) {
?>
    <div class="shooting_card" data-lng="<?php echo $shot["longitude"] ?>" data-lat="<?php echo $shot["latitude"] ?>">

        <button class="shooting_header" type="button" aria-expanded="false">

            <div class="shooting_info">
                <span class="material-symbols-rounded">crisis_alert</span>

                <div class="shooting_main_info">
                    <span class="shooting_id">Incident <?php echo $index; ?></span>
                    <span class="shooting_location"><?php echo $shot["city"] . ", " . $shot["state"] . ", " . $shot["country"]; ?></span>
                </div>
            </div>

            <span class="material-symbols-rounded shooting_arrow">keyboard_arrow_down</span>
        </button>

        <div class="shooting_details">

            <div class="detail_item">
                <span class="detail_label">DATE AND TIME</span>
                <span class="detail_value"><?php echo $shot["date_gunshot"]; ?></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">CARTESIAN COORDENATE</span>
                <span class="detail_value"><?php echo $shot["latitude"] . ", " . $shot["longitude"]; ?></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">GUN TYPE</span>
                <span class="detail_value"><?php echo $shot["type_gun"] . ": " . $shot["accuracy"] . "%"; ?></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">STREET</span>
                <span class="detail_value"><?php echo $shot["street"] . ", " . $shot["neighborhood"]; ?></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">CITY</span>
                <span class="detail_value"><?php echo $shot["city"] . ", " . $shot["state"]; ?></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">COUNTRY</span>
                <span class="detail_value"><?php echo $shot["country"]; ?></span>
            </div>
        </div>
    </div>
<?php
    };
?>