<?php

    function verify_expiration() {

        if (!isset($_SESSION["expiration_time"]) || time() >= $_SESSION["expiration_time"]) {
            
            $_SESSION = [];
            session_destroy();

            header("Location: ../../index.html");
            exit();
        }
    }
?>