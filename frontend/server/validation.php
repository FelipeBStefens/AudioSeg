<?php

    if (!isset($_SESSION["user_data"])) {
        
        header("Location: ../index.html");
        exit();
    }
?>