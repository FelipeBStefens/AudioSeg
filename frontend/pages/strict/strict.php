<?php
    session_start();
    
    include __DIR__ . "/../../server/security/validation.php";
    include __DIR__ . "/../../server/security/expiration.php";

    if (!validate_director()) {
        redirect();
    }

    verify_expiration();
?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="../../style/strict/strict.css">

        <title>AudioSeg - Strict</title>
    </head>

    <body>
        <?php include __DIR__ . "/../header/header.php"?>
    </body>
</html>