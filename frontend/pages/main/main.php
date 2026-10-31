<?php
    session_start();
    
    include __DIR__ . "/../../server/security/validation.php";
    include __DIR__ . "/../../server/security/expiration.php";
    include __DIR__ . "/../../server/main/shoot_service.php";

    if (!validate_user()) {
        redirect();
    }

    verify_expiration();
?>

<!DOCTYPE html>

<html lang="en">

    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="icon" href="../../assets/images/AudioSegLogo.png" type="image/png">
        <link rel="stylesheet" href="../../style/main/main.css">
        <link rel="stylesheet" href="https://unpkg.com/maplibre-gl@6.16.0/dist/maplibre-gl.css">
        <script type="module" src="../../script/main/main_map.js"></script>
        
        <title>AudioSeg - Main</title>
    </head>

    <body>
        <?php include __DIR__ . "/../header/header.php"?>  

        <main>   
            <aside class="sidebar">

                <div class="sidebar_heading">
                    <div class="heading_icon">
                        <span class="material-symbols-rounded">public</span>
                    </div>

                    <h2>Public Shootings</h2>
                </div>

                <div class="sidebar_content">
                    <div class="shootings_summary">
                        <span class="summary_label">REGISTERED INCIDENTS</span>
                        <span class="summary_value">24</span>
                    </div>

                    <div class="shootings_section">

                        <h3>Recent Incidents</h3>

                        <div class="shootings_list">
                            <?php 
                                for ($i = 0; $i <= 20; $i++) {
                                    create_shoot();
                                }  
                            ?>
                        </div>
                    </div>
                </div>
            </aside>

            <section class="map_container">
                <div id="map"></div>
            </section>
        </main>
    </body>
</html>