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
        <link rel="stylesheet" href="../../style/strict/real_time_map.css">

        <title>AudioSeg - Researcher Settings</title>
    </head>

    <body>
        <?php include __DIR__ . "/../header/header.php"?>

        <h1>Researchers Settings</h1>
    </body>
</html>