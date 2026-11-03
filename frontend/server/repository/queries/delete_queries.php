<?php

    function delete_phone() {
        return "
            DELETE FROM phone WHERE id_phone = ?;
        ";
    }

    function delete_address() {
        return "
            DELETE FROM address WHERE id_address = ?;
        ";
    }

    function delete_housing() {
        return "
            DELETE FROM housing WHERE id_housing = ?;
        ";
    }

    function delete_user() {
        return "
            DELETE FROM users WHERE id_user = ?;
        ";
    }

    function delete_researcher() {
        return "
            DELETE FROM researcher WHERE id_researcher = ?
        ";
    }
?>