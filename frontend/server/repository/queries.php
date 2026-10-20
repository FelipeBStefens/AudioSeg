<?php

    session_start();

    function get_sql_auth() {
        return "SELECT id_user, password_hash, role_user FROM users WHERE email = ?;";
    }

    function get_sql_researcher_sign_in() {
        return "SELECT * FROM (((researcher AS r INNER JOIN users AS u ON r.id_user = u.id_user) INNER JOIN housing AS h ON u.id_housing = h.id_housing) INNER JOIN address AS a ON h.id_address = a.id_address) INNER JOIN phone AS p ON u.id_phone = p.id_phone WHERE u.id_user = ?;";
    }

    function get_sql_policeman_sign_in() {
        return "SELECT * FROM ((((((policeman AS po INNER JOIN users AS u ON po.id_user = u.id_user) INNER JOIN police_station AS ps ON po.id_police_station = ps.id_police_station) INNER JOIN housing AS h ON ps.id_housing = h.id_housing) INNER JOIN address AS a ON h.id_address = a.id_address) INNER JOIN housing AS hs ON u.id_housing = hs.id_housing) INNER JOIN address AS ac ON hs.id_address = ac.id_address) INNER JOIN phone AS p ON u.id_phone = p.id_phone WHERE u.id_user = ?;";
    } 

    function get_sql_delegate_sign_in() {
        return "SELECT * FROM ((((((policeman AS po INNER JOIN users AS u ON po.id_user = u.id_user) INNER JOIN police_station AS ps ON po.id_police_station = ps.id_police_station) INNER JOIN housing AS h ON ps.id_housing = h.id_housing) INNER JOIN address AS a ON h.id_address = a.id_address) INNER JOIN housing AS hs ON u.id_housing = hs.id_housing) INNER JOIN address AS ac ON hs.id_address = ac.id_address) INNER JOIN phone AS p ON u.id_phone = p.id_phone WHERE u.id_user = ?;";
    }

    function get_sql_director_sign_in() {
        return "SELECT * FROM (((director AS d INNER JOIN users AS u ON d.id_user = u.id_user) INNER JOIN housing AS h ON u.id_housing = h.id_housing) INNER JOIN address AS a ON h.id_address = a.id_address) INNER JOIN phone AS p ON u.id_phone = p.id_phone WHERE u.id_user = ?;";
    }

    function create_phone() {
        return "INSERT INTO phone (international_dialling_code, local_dialling_code, number_phone) VALUES (?, ?, ?);";
    }

    function create_address() {
        return "INSERT INTO address (country, state, city, neighborhood, street) VALUES (?, ?, ?, ?, ?);";
    }

    function create_housing() {
        return "INSERT INTO housing (cep, number_house, additional_information, id_address) VALUES (?, ?, ?, ?);";
    }

    function create_user() {
        return "INSERT INTO users (username, email, password_hash, cpf, birth_date, photo, id_phone, id_housing) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    }

    function create_researcher() {
        return "INSERT INTO researcher (insitute, id_user) VALUES (?, ?);";
    }
?>