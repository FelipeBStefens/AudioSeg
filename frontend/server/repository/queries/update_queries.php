<?php

    function update_phone(){
        return "
            UPDATE phone
            SET international_dialling_code = ?, local_dialling_code = ?, number_phone = ?
            WHERE id_phone = ?;
        ";
    }

    function update_address(){
        return "
            UPDATE address
            SET country = ?, state = ?, city = ?, neighborhood = ?, street = ?
            WHERE id_address = ?;
        ";
    }

    function update_housing(){
        return "
            UPDATE housing
            SET cep = ?, number_house = ?, additional_information = ?
            WHERE id_housing = ?;
        ";
    }

    function update_user(){
        return "
            UPDATE users
            SET username = ?, email = ?, password_hash = ?, birth_date = ?, description_user = ?
            WHERE id_user = ?;
        ";
    }
?>