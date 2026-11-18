
<?php
    function show_police_stations(array $station) {
        
        $policemen = $station["policemen"] ?? [];

?>

<article class="station_item researcher_item">

    <!-- STATION HEADER -->

    <button class="station_trigger researcher_trigger" type="button" aria-expanded="false">

        <div class="researcher_identity">

            <img src="../../assets/images/profile_photo.jpg" alt="Police station" class="researcher_photo">

            <div class="researcher_summary">

                <h3><?php echo ($station["name_police_station"]) ?></h3>

                <span><?php echo ($station["city"]) ?></span>

            </div>

        </div>

        <div class="researcher_metadata">

            <span class="institute_tag">
                <?php echo ($station["city"] ?? "Police Station") ?>
            </span>

            <span class="material-symbols-rounded expand_icon">
                keyboard_arrow_down
            </span>

        </div>

    </button>


    <!-- STATION DETAILS -->

    <div class="researcher_details">

        <div class="details_content">

            <div class="details_heading">

                <div>
                    <span class="eyebrow">STATION INFORMATION</span>
                    <h3>Police Station Details</h3>
                </div>

            </div>


            <!-- STATION PROFILE -->

            <div class="profile_overview">

                <img src="../../assets/images/profile_photo.jpg" alt="Police station" class="details_photo">

                <div>

                    <h2><?php echo ($station["name_police_station"]) ?></h2>

                    <p><?php echo ($station["city"] ?? "") ?></p>

                    <span>POLICE STATION</span>

                </div>

            </div>


            <!-- STATION INFORMATION -->

            <div class="information_grid">

                <div class="information_group">
                    <span>Station Name</span>
                    <strong><?php echo ($station["name_police_station"]) ?></strong>
                </div>

                <div class="information_group">
                    <span>City</span>
                    <strong><?php echo ($station["city"] ?? "") ?></strong>
                </div>

                <div class="information_group">
                    <span>Country</span>
                    <strong><?php echo ($station["country"]) ?></strong>
                </div>

                <div class="information_group">
                    <span>Neighborhood</span>
                    <strong><?php echo ($station["neighborhood"] ?? "") ?></strong>
                </div>

                <div class="information_group">
                    <span>State</span>
                    <strong><?php echo ($station["state"] ?? "") ?></strong>
                </div>

                <div class="information_group">
                    <span>Street</span>
                    <strong><?php echo ($station["street"] . ", " . $station["number_house"] ?? "") ?></strong>
                </div>
            </div>


            <!-- POLICE OFFICERS -->

            <section class="officers_section">

                <div class="officers_heading">

                    <div>
                        <span class="eyebrow">STATION MANAGEMENT</span>
                        <h3>Registered Officers</h3>
                        <p>Manage the officers assigned to this police station.</p>
                    </div>

                    <span class="officer_counter">
                        <?php echo count($policemen) ?> Officers
                    </span>

                </div>


                <!-- OFFICER LIST -->

                <div class="officers_list">

                    <?php foreach ($policemen as $policeman): ?>

                        <article class="officer_item" data-officer-id="<?php echo ($policeman["id_policeman"] ?? "") ?>">

                            <div class="officer_identity">

                                <img src="../../assets/images/profile_photo.jpg" alt="Police officer" class="officer_photo">

                                <div>
                                    <h4 class="policeman_name">
                                        <?php echo ($policeman["username"]);?> 

                                        <?php
                                            if($policeman["status_policeman"] == "ACTIVE"){
                                        ?>
                                            <p class="policeman_status p_active"><?php echo $policeman["status_policeman"] ?></p>
                                        <?php
                                            }else{
                                        ?>
                                            <p class="policeman_status p_inactive"><?php echo $policeman["status_policeman"] ?></p>
                                        <?php
                                            }
                                        ?>

                                        
                                    </h4>
                                    <span><?php echo ($policeman["email"]) ?></span>
                                    <span><?php echo ($policeman["start_period"] . " - " . $policeman["end_period"]) ?></span>
                                </div>

                            </div>

                            <button type="button" class="remove_officer" title="Remove officer">
                                <span class="material-symbols-rounded">person_remove</span>
                                <span>Remove</span>
                            </button>

                        </article>

                    <?php endforeach; ?>

                    <?php if (empty($policemen)): ?>

                        <div class="empty_officers">
                            <span class="material-symbols-rounded">group_off</span>
                            <p>No officers registered in this station.</p>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- ADD OFFICER -->

                <div class="add_officer_section">

                    <div class="add_officer_heading">

                        <div>
                            <h4>Add an Officer</h4>
                            <p>Assign a new police officer to this station.</p>
                        </div>

                        <span class="material-symbols-rounded">
                            person_add
                        </span>

                    </div>

                    <form class="add_officer_form">

                        <div class="officer_form_group">

                            <label>Officer Username</label>

                            <input type="text" name="officer_username" placeholder="Enter officer username" required>

                        </div>

                        <div class="officer_form_group">

                            <label>Officer Email</label>

                            <input type="email" name="officer_email" placeholder="Enter officer email" required>

                        </div>

                        <button type="submit" class="add_officer_button">

                            <span class="material-symbols-rounded">
                                person_add
                            </span>

                            Add Officer

                        </button>

                    </form>

                </div>

            </section>


            <!-- DANGER ZONE -->

            <div class="researcher_actions">

                <div>
                    <h4>Danger Zone</h4>
                    <p>Permanently remove this police station account.</p>
                </div>

                <button type="button" class="delete_researcher">

                    <span class="material-symbols-rounded">delete</span>
                    <p>Delete Station</p>

                </button>

            </div>

        </div>

    </div>

</article>

<?php
    }
         
    require_once __DIR__ . "/../repository/data_access_object/police_station_repository.php";

    $stations = get_police_stations($_SESSION["user_data"]["role_user"]);

    foreach ($stations as $station) {
        show_police_stations($station);
    }
?>
