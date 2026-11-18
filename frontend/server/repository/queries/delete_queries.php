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

    function delete_police_station(){
        return "
            DELETE FROM police_station WHERE id_police_station = ?; 
        ";
    }

    function delete_policeman(){
        return "
            DELETE FROM policeman WHERE id_policeman = ?;
        ";
    }

    function delete_station_sensors() {
        return "
            DELETE FROM sensor WHERE id_police_station = ?
        ";
    }

    function delete_station_policemen() {
        return "
            DELETE FROM policeman WHERE id_police_station = ?
        ";
    }

    function delete_station_delegates() {
        return "
            DELETE FROM delegate WHERE id_police_station = ?
        ";
    }
?>