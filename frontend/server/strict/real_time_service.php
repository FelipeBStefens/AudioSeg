<?php
    function create_shoot(int $index, array $shot) {
?>
    <div class="shooting_card" data-lng="<?php echo $shot["shot_longitude"]; ?>" data-lat="<?php echo $shot["shot_latitude"]; ?>">

        <button class="shooting_header" type="button" aria-expanded="false">

            <div class="shooting_info">
                <span class="material-symbols-rounded">crisis_alert</span>

                <div class="shooting_main_info">
                    <span class="shooting_id">Incident <?php echo $index; ?></span>
                    <span class="shooting_location"><?php echo $shot["shot_city"] . ", " . $shot["shot_state"] . ", " . $shot["shot_country"]; ?></span>
                </div>
            </div>

            <span class="material-symbols-rounded shooting_arrow">keyboard_arrow_down</span>
        </button>

        <div class="shooting_details">
            
            <!-- To implement -->
            <button>Make it public</button>
            <button>Go there</button>
            
            <div class="detail_item">
                <span class="detail_label">DATE AND TIME</span>
                <span class="detail_value"><?php echo $shot["date_gunshot"]; ?></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">CARTESIAN COORDENATE</span>
                <span class="detail_value"><?php echo $shot["shot_latitude"] . ", " . $shot["shot_longitude"]; ?></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">GUN TYPE</span>
                <span class="detail_value"><?php echo $shot["type_gun"] . ": " . $shot["accuracy"] . "%"; ?></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">STREET</span>
                <span class="detail_value"><?php echo $shot["shot_street"] . ", " . $shot["shot_neighborhood"]; ?></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">CITY</span>
                <span class="detail_value"><?php echo $shot["shot_city"] . ", " . $shot["shot_state"]; ?></span>
            </div>

            <div class="detail_item">
                <span class="detail_label">COUNTRY</span>
                <span class="detail_value"><?php echo $shot["shot_country"]; ?></span>
            </div>
        </div>
    </div>
<?php
    };
    
    require_once __DIR__ . "/../repository/data_access_object/real_time_repository.php";

    $role_user = $_SESSION["user_data"]["role_user"];

    $public_shots = get_real_time_shots($role_user);
    $index = 1;

    foreach($public_shots as $shot) {
        create_shoot($index, $shot);
        $index += 1;
    }
?>