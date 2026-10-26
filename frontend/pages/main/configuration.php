<?php
    session_start();
    include __DIR__ . "/../server/validation.php";

    if (!validate_user()) {
        redirect();
    }
?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>AudioSeg - User Configuration</title>
    </head>

    <body>
        
    </body>
</html>