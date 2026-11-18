<?php

    function show_police_stations(array $station) {
        
        $policemen = $station["policemen"] ?? [];
?>

        <article class="station_item researcher_item">

            <button class="station_trigger researcher_trigger" type="button" aria-expanded="false">

                <div class="researcher_identity">   
                    <img src="../../assets/images/police_station.png" alt="Police station" class="researcher_photo">

                    <div class="researcher_summary">
                        <h3><?php echo ($station["name_police_station"]) ?></h3>
                        <span><?php echo ($station["city"]) ?></span>
                    </div>
                </div>

                <div class="researcher_metadata">
                    <span class="institute_tag">
                        <?php echo ($station["city"] ?? "Police Station") ?>
                    </span>

                    <span class="material-symbols-rounded expand_icon">keyboard_arrow_down</span>
                </div>
            </button>

            <div class="researcher_details">

                <div class="details_content">

                    <div class="details_heading">
                        <div>
                            <span class="eyebrow">STATION INFORMATION</span>
                            <h3>Police Station Details</h3>
                        </div>
                    </div>

                    <div class="profile_overview">
                        <img src="../../assets/images/police_station.png" alt="Police station" class="details_photo">

                        <div>
                            <h2><?php echo ($station["name_police_station"]) ?></h2>
                            <p><?php echo ($station["city"] ?? "") ?></p>
                            
                            <span>POLICE STATION</span>
                        </div>
                    </div>

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

                        <div class="officers_list">

                            <?php foreach ($policemen as $policeman) { ?>

                                <article class="officer_item" data-officer-id="<?php echo ($policeman["id_policeman"] ?? "") ?>">
                                    <div class="officer_identity">
                                        
                                    <img src="../../assets/images/profile_photo.jpg" alt="Police officer" class="officer_photo">
                                        <div>
                                            <h4 class="policeman_name">
                                                <?php echo ($policeman["username"]); ?> 

                                                <?php 
                                                    $status = $policeman["status_policeman"];
                                                    
                                                    if($status == "ACTIVE") { 
                                                        echo "<p class='policeman_status p_active'>$status</p>";
                                                    }
                                                    else {
                                                        echo "<p class='policeman_status p_inactive'>$status</p>";
                                                    }
                                                ?>
                                            </h4>
                                            <span><?php echo ($policeman["email"]) ?></span>
                                            <span><?php echo ($policeman["start_period"] . " - " . $policeman["end_period"]) ?></span>
                                        </div>
                                    </div>

                                    <form action="../../server/strict/police_and_station_service.php" method="post">

                                        <input type="hidden" name="action" value="police">
                                        <input type="hidden" name="id_user" value="<?php echo $policeman["id_user"]; ?>">
                                        <input type="hidden" name="id_address" value="<?php echo $policeman["id_address"]; ?>">
                                        <input type="hidden" name="id_phone" value="<?php echo $policeman["id_phone"]; ?>">
                                        <input type="hidden" name="id_notification" value="<?php echo $policeman["id_notification"]; ?>">

                                        <button type="submit" class="remove_officer" title="Remove officer">
                                            <span class="material-symbols-rounded">person_remove</span>
                                            <span>Remove</span>
                                        </button>
                                    </form>
                                </article>
                            <?php } ?>

                            <?php if (empty($policemen)) { ?>

                                <div class="empty_officers">
                                    <span class="material-symbols-rounded">group_off</span>
                                    <p>No officers registered in this station.</p>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="add_officer_section">

                            <div class="add_officer_heading">
                                <div>
                                    <h4>Add a policeman</h4>
                                    <p>Assign a new policeman to this station.</p>
                                </div>

                                <span class="material-symbols-rounded">person_add</span>
                            </div>

                            <form action="../../server/strict/police_and_station_service.php" method="POST" class="add_officer_form">

                                <input type="hidden" name="action" value="create_policeman">
                                <input type="hidden" name="id_police_station" value="<?php echo $station["id_police_station"]; ?>">

                                <div class="officer_form_group">
                                    <label>Policeman Username</label>
                                    <input type="text" name="policeman_username" placeholder="Enter policeman username" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Policeman Email</label>
                                    <input type="email" name="policeman_email" placeholder="Enter policeman email" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Policeman Password</label>
                                    <input type="password" name="policeman_password" placeholder="Enter policeman password" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Policeman CPF</label>
                                    <input class="cpf" type="text" name="policeman_cpf" placeholder="Enter policeman cpf" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Policeman Phone</label>
                                    <input class="phone" type="text" name="policeman_phone" placeholder="Enter policeman phone" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Policeman Birth Date</label>
                                    <input type="date" name="policeman_birth_date" placeholder="Enter policeman birth date" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Policeman Badge</label>
                                    <input type="text" name="policeman_badge" placeholder="Enter policeman badge" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Policeman Start Period</label>
                                    <input type="time" name="policeman_start_period" placeholder="Enter policeman start period" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Policeman End Period</label>
                                    <input type="time" name="policeman_end_period" placeholder="Enter policeman end period" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Policeman Status</label>
                                    <select name="status">
                                        <option value="ACTIVE">ACTIVE</option>
                                        <option value="INACTIVE">INACTIVE</option>
                                    </select>
                                </div>

                                <button type="submit" class="add_officer_button">
                                    <span class="material-symbols-rounded">person_add</span>
                                    Add Policeman
                                </button>
                            </form>
                        </div>

                        <div class="add_officer_section">

                            <div class="add_officer_heading">                              
                                <div>
                                    <h4>Add a Delegate</h4>
                                    <p>Assign a new delegate to this station.</p>
                                </div>

                                <span class="material-symbols-rounded">person_add</span>
                            </div>

                            <form action="../../server/strict/police_and_station_service.php" method="POST" class="add_officer_form">

                                <input type="hidden" name="action" value="create_delegate">
                                <input type="hidden" name="id_police_station" value="<?php echo $station["id_police_station"]; ?>">

                                <div class="officer_form_group">
                                    <label>Delegate Username</label>
                                    <input type="text" name="delegate_username" placeholder="Enter delegate username" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Delegate Email</label>
                                    <input type="email" name="delegate_email" placeholder="Enter delegate email" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Delegate Password</label>
                                    <input type="password" name="delegate_password" placeholder="Enter delegate password" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Delegate CPF</label>
                                    <input class="cpf" type="text" name="delegate_cpf" placeholder="Enter delegate cpf" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Delegate Phone</label>
                                    <input class="phone" type="text" name="delegate_phone" placeholder="Enter delegate phone" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Delegate Birth Date</label>
                                    <input type="date" name="delegate_birth_date" placeholder="Enter delegate birth date" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Delegate Start Period</label>
                                    <input type="time" name="delegate_start_period" placeholder="Enter delegate start period" required>
                                </div>

                                <div class="officer_form_group">
                                    <label>Delegate End Period</label>
                                    <input type="time" name="delegate_end_period" placeholder="Enter delegate end period" required>
                                </div>

                                <button type="submit" class="add_officer_button">
                                    <span class="material-symbols-rounded">person_add</span>
                                    Add Delegate
                                </button>
                            </form>
                        </div>
                    </section>

                    <div class="researcher_actions">
                        
                        <div>
                            <h4>Danger Zone</h4>
                            <p>Permanently remove this police station account.</p>
                        </div>
                        
                        <form action="../../server/strict/police_and_station_service.php" method="post">

                            <input type="hidden" name="action" value="station">
                            <input type="hidden" name="id_station" value="<?php echo $station["id_police_station"] ?>">
                            <input type="hidden" name="id_address" value="<?php echo $station["id_address"] ?>">

                            <button type="submit" class="delete_researcher">
                                <span class="material-symbols-rounded">delete</span>
                                <p>Delete Station</p>
                            </button>
                        </form>
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