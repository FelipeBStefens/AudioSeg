<?php
    session_start();
    
    include __DIR__ . "/../../server/security/validation.php";
    include __DIR__ . "/../../server/security/expiration.php";
    include __DIR__ . "/../../server/main/shoot_service.php";

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
        
        <link rel="icon" href="../../assets/images/AudioSegLogo.png" type="image/png">
        <link rel="stylesheet" href="../../style/main/main.css">
        <link rel="stylesheet" href="../../style/strict/real_time_map.css">
        <link rel="stylesheet" href="https://unpkg.com/maplibre-gl@6.16.0/dist/maplibre-gl.css">
        <script type="module" src="../../script/main/main_map.js"></script>
        
        <title>AudioSeg - Real Time Map</title>
    </head>

    <body>
        <?php include __DIR__ . "/../header/header.php"?>  

        <main>   
            <section class="map_container">
                <div id="map"></div>
            </section>

            <aside class="sidebar">

                <div class="sidebar_heading">
                    <div class="heading_icon">
                        <span class="material-symbols-rounded">public</span>
                    </div>

                    <h2>Real Time Shoots</h2>
                </div>

                <div class="sidebar_content">

                    <div class="shootings_list">
                        <?php 
                            include_once __DIR__ . "/../../server/main/main_service.php";
                        ?>
                    </div>
                </div>
            </aside>
        </main>
    </body>
</html>