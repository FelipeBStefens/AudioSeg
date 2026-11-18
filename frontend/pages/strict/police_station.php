<?php
    session_start();
    
    include __DIR__ . "/../../server/security/validation.php";
    include __DIR__ . "/../../server/security/expiration.php";

    if (!(validate_policeman() || validate_delegate() || validate_director())) {
        redirect();
    }

    verify_expiration();
?>

<!DOCTYPE html>
 
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="../../assets/images/audioseg_logo.png" type="image/png">
        <link rel="stylesheet" href="../../style/strict/police_station.css">
        <script src="../../script/strict/police_station.js" defer></script>

        <title>AudioSeg - Police Stations</title>
    </head>

    <body>
        <?php include __DIR__ . "/../header/header.php"?>

        <main class="researchers_container">

            <div class="page_heading">
                <div>
                    <span class="eyebrow">ADMINISTRATION PANEL</span>
                    <h1>Police Station Settings</h1>
                    <p>Manage police stations and their registered officers.</p>
                </div>

                <div class="info_station">

                    <a class="researcher_counter add_station_bt" href="add_police_station.php">
                        <span class="material-symbols-rounded">add</span>
                        <h5><span class="add_span">ADD</span> POLICE STATION</h5>
                    </a>

                    <div class="researcher_counter">
                        <span class="material-symbols-rounded">local_police</span>
                        <div>
                            <strong>Police Stations</strong>
                            <span>Registered stations</span>
                        </div>
                        <span class="counter_number" id="station_counter"></span>
                    </div>
                </div>
            </div>

            <section class="researchers_section">

                <div class="section_heading">
                    <div>
                        <h2>Registered Police Stations</h2>
                        <p>Select a police station to manage its information and officers.</p>
                    </div>

                    <span class="material-symbols-rounded section_icon">manage_accounts</span>
                </div>

                <div class="researcher_search">
                    <span class="material-symbols-rounded">search</span>
                    <input type="search" id="station_search_input" placeholder="Search police stations or officers..." autocomplete="off">
                    <span class="search_shortcut">SEARCH</span>
                </div>

                <p class="search_results" id="search_results"></p>

                <div class="researchers_list" id="stations_list">
                    <?php require_once __DIR__ . "/../../server/strict/show_police_station_service.php"?>
                </div>

            </section>
        </main>
    </body>
</html>