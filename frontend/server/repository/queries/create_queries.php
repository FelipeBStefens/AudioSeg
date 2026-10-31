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

    function create_housing() {
        return "
            INSERT INTO housing (cep, number_house, additional_information, id_address) 
            VALUES (?, ?, ?, ?);
        ";
    }

    function create_user() {
        return "
            INSERT INTO users (username, email, password_hash, cpf, birth_date, id_phone, id_housing) 
            VALUES (?, ?, ?, ?, ?, ?, ?);
        ";
    }

    function create_researcher() {
        return "
            INSERT INTO researcher (institute, id_user) 
            VALUES (?, ?);
        ";
    }
?>