<?php
    session_start();
    
    include __DIR__ . "/../../server/security/validation.php";
    include __DIR__ . "/../../server/security/expiration.php";

    if (!(validate_delegate() || validate_director())) {
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
        <link rel="stylesheet" href="../../style/strict/researcher_settings.css">
        <script src="../../script/strict/researcher_settings.js" defer></script>

        <title>AudioSeg - Researcher Settings</title>
    </head>

    <body>
        <?php include __DIR__ . "/../header/header.php"?>

        <main class="researchers_container">

            <div class="page_heading">
                <div>
                    <span class="eyebrow">ADMINISTRATION PANEL</span>
                    <h1>Researchers Settings</h1>
                </div>

                <div class="researcher_counter">
                    <span class="material-symbols-rounded">groups</span>
                    <div>
                        <strong>Researchers</strong>
                        <span>Registered accounts</span>
                    </div>
                    <span class="counter_number">67</span>
                </div>
            </div>

            <section class="researchers_section">

                <div class="section_heading">
                    <div>
                        <h2>Registered Researchers</h2>
                        <p>Select a researcher to view their information.</p>
                    </div>
                    <span class="material-symbols-rounded section_icon">manage_accounts</span>
                </div>

                <div class="researcher_search">
                    <span class="material-symbols-rounded">search</span>
                    <input type="search" id="researcher_search_input" placeholder="Search by username" autocomplete="off">
                    <span class="search_shortcut">SEARCH</span>
                </div>

                <p class="search_results" id="search_results"></p>

                <div class="researchers_list">
                    
                    <?php 
                        require_once __DIR__ . "/../../server/strict/show_researcher_service.php";

                        for ($i = 0; $i < 100; $i++) {
                            show_researchers();
                        }
                    ?>
                </div>
            </section>
        </main>
    </body>
</html>