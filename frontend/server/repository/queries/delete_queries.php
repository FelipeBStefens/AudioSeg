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

    function delete_user() {
        return "
            DELETE FROM users WHERE id_user = ?;
        ";
    }

    function delete_notification(){
        return "
            DELETE FROM notification WHERE id_notification = ?;
        ";
    }
?>