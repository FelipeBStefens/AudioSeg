<?php
    session_start();
    include __DIR__ . "/../../server/validation.php";

    if (!validate_user()) {
        redirect();
    }
?>

<!DOCTYPE html>

<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>AudioSeg - Public Statistics</title>
    </head>

    <body>
        <?php include __DIR__ . "/../header/header.php"?>

        <main>
            <h1>Hello</h1> 
        </main>
    </body>
</html>