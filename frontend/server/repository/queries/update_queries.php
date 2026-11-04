<?php

    function update_phone() {
        return "
            UPDATE phone AS p INNER JOIN users AS u ON p.id_phone = u.id_phone
            SET p.international_dialling_code = ?, p.local_dialling_code = ?, p.number_phone = ?
            WHERE u.id_user = ?;
        ";
    }

    function update_address() {
        return "
            UPDATE address
            SET country = ?, state = ?, city = ?, neighborhood = ?, street = ?
            WHERE id_address = ?;
        ";
    }

    function update_housing() {
        return "
            UPDATE housing
            SET cep = ?, number_house = ?, additional_information = ?
            WHERE id_housing = ?;
        ";
    }

    function update_user() {
        return "
            UPDATE users
            SET username = ?, birth_date = ?, description_user = ?, photo = ?
            WHERE id_user = ?;
        ";
    }

    function update_researcher() {
        return "
            UPDATE users AS u INNER JOIN researcher AS r ON u.id_user = r.id_user
            SET u.username = ?, u.birth_date = ?, u.description_user = ?, u.photo = ?, r.institute = ?
            WHERE u.id_user = ?;
        ";
    }

    function update_email() {
        return "
            UPDATE users
            SET email = ?
            WHERE id_user = ?;
        ";
    }

    function update_password() {
        return "
            UPDATE users
            SET password_hash = ?
            WHERE id_user = ?;
        ";
    }
?>