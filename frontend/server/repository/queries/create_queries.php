<?php

    function create_phone() {
        return "
            INSERT INTO phone (international_dialling_code, local_dialling_code, number_phone)
            VALUES (?, ?, ?);
        ";
    }

    function create_address() {
        return "
            INSERT INTO address (country, state, city, neighborhood, street) 
            VALUES (?, ?, ?, ?, ?);
        ";
    }

    function create_address_default(){
        return "
            INSERT INTO address (city, neighborhood, street) 
            VALUES (?, ?, ?);
        ";
    }

    function create_housing() {
        return "
            INSERT INTO housing (cep, number_house, additional_information, id_address) 
            VALUES (?, ?, ?, ?);
        ";
    }

    function create_user() {
        return "
            INSERT INTO users (username, email, password_hash, cpf, birth_date, id_phone, id_housing, id_notification) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?);
        ";
    }

    function create_role_user() {
        return "
            INSERT INTO users (username, email, password_hash, role_user, cpf, birth_date, id_phone, id_housing, id_notification) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);
        ";
    }

    function create_researcher() {
        return "
            INSERT INTO researcher (institute, id_user) 
            VALUES (?, ?);
        ";
    }

    function create_notification(){
        return "
            INSERT INTO notification () 
            VALUES ();
        ";
    }

    function insert_policeman(){
        return "
            INSERT INTO policeman (badge, status_policeman, start_period, end_period, id_user, id_police_station)
            VALUES ( ?, ?, ?, ?, ?, ?);
        ";
    }

    function insert_delegate(){
        return "
            INSERT INTO delegate (start_period, end_period, id_user, id_police_station)
            VALUES (?, ?, ?, ?)
        ";
    }
?>