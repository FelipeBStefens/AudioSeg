<?php

    function redirect() {

        header("Location: ../index.html");
        exit();
    }

    function validate_user() {

        if (!isset($_SESSION["user_data"])) {
            return false;
        }

        return true;        
    }

    function validate_researcher() {

        if (!isset($_SESSION["user_data"])) {
            return false;
        }

        if ($_SESSION["user_data"]["role_user"] == "RESEARCHER") {
            return true;
        }

        return false;
    }

    function validate_policeman() {

        if (!isset($_SESSION["user_data"])) {
            return false;
        }

        if ($_SESSION["user_data"]["role_user"] == "POLICEMAN") {
            return true;
        }

        return false;
    }

    function validate_delegate() {

        if (!isset($_SESSION["user_data"])) {
            return false;
        }

        if ($_SESSION["user_data"]["role_user"] == "DELEGATE") {
            return true;
        }

        return false;
    }

    function validate_director() {

        if (!isset($_SESSION["user_data"])) {
            return false;
        }

        if ($_SESSION["user_data"]["role_user"] == "DIRECTOR") {
            return true;
        }

        return false;
    }
?>