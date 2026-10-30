<?php

    //=========================
    //  GET FUNCTIONS
    //=========================

    function get_sql_auth() {
        return "
            SELECT id_user, password_hash, role_user 
            FROM users 
            WHERE email = ?;
        ";
    }

    function get_sql_researcher_sign_in() {
        return "
            SELECT
                r.id_researcher,
                r.institute,
                r.expiration_date,
                r.id_user,

                u.id_user,
                u.username,
                u.email,
                u.role_user,
                u.cpf,
                u.birth_date,
                u.photo,
                u.description_user,
                u.id_phone,
                u.id_housing,

                h.id_housing,
                h.cep,
                h.number_house,
                h.additional_information,
                h.id_address,

                a.id_address,
                a.country,
                a.state,
                a.city,
                a.neighborhood,
                a.street,

                p.id_phone,
                p.international_dialling_code,
                p.local_dialling_code,
                p.number_phone

            FROM researcher AS r
                INNER JOIN users AS u ON r.id_user = u.id_user
                INNER JOIN housing AS h ON u.id_housing = h.id_housing
                INNER JOIN address AS a ON h.id_address = a.id_address
                INNER JOIN phone AS p ON u.id_phone = p.id_phone

            WHERE u.id_user = ?;
        ";
    }

    function get_sql_policeman_sign_in() {
        return "
            SELECT
                po.id_policeman,
                po.badge,
                po.status_policeman,
                po.start_period,
                po.end_period,
                po.id_user,
                po.id_police_station,

                u.id_user,
                u.username,
                u.email,
                u.role_user,
                u.cpf,
                u.birth_date,
                u.photo,
                u.description_user,
                u.id_phone,
                u.id_housing,

                ps.id_police_station,
                ps.name_police_station,
                ps.id_housing,

                h.id_housing,
                h.cep,
                h.number_house,
                h.additional_information,
                h.id_address,

                a.id_address,
                a.country,
                a.state,
                a.city,
                a.neighborhood,
                a.street,

                hs.id_housing,
                hs.cep,
                hs.number_house,
                hs.additional_information,
                hs.id_address,

                ac.id_address,
                ac.country,
                ac.state,
                ac.city,
                ac.neighborhood,
                ac.street,

                p.id_phone,
                p.international_dialling_code,
                p.local_dialling_code,
                p.number_phone

            FROM policeman AS po
                INNER JOIN users AS u ON po.id_user = u.id_user
                INNER JOIN police_station AS ps ON po.id_police_station = ps.id_police_station
                INNER JOIN housing AS h ON ps.id_housing = h.id_housing
                INNER JOIN address AS a ON h.id_address = a.id_address
                INNER JOIN housing AS hs ON u.id_housing = hs.id_housing
                INNER JOIN address AS ac ON hs.id_address = ac.id_address
                INNER JOIN phone AS p ON u.id_phone = p.id_phone

            WHERE u.id_user = ?;
        ";
    }

    function get_sql_delegate_sign_in() {
        return "
            SELECT
                d.id_delegate,
                d.start_period,
                d.end_period,
                d.id_user,
                d.id_police_station,

                u.id_user,
                u.username,
                u.email,
                u.role_user,
                u.cpf,
                u.birth_date,
                u.photo,
                u.description_user,
                u.id_phone,
                u.id_housing,

                ps.id_police_station,
                ps.name_police_station,
                ps.id_housing,

                h.id_housing,
                h.cep,
                h.number_house,
                h.additional_information,
                h.id_address,

                a.id_address,
                a.country,
                a.state,
                a.city,
                a.neighborhood,
                a.street,

                hs.id_housing,
                hs.cep,
                hs.number_house,
                hs.additional_information,
                hs.id_address,

                ac.id_address,
                ac.country,
                ac.state,
                ac.city,
                ac.neighborhood,
                ac.street,

                p.id_phone,
                p.international_dialling_code,
                p.local_dialling_code,
                p.number_phone

            FROM delegate AS d
                INNER JOIN users AS u ON d.id_user = u.id_user
                INNER JOIN police_station AS ps ON d.id_police_station = ps.id_police_station
                INNER JOIN housing AS h ON ps.id_housing = h.id_housing
                INNER JOIN address AS a ON h.id_address = a.id_address
                INNER JOIN housing AS hs ON u.id_housing = hs.id_housing
                INNER JOIN address AS ac ON hs.id_address = ac.id_address
                INNER JOIN phone AS p ON u.id_phone = p.id_phone

            WHERE u.id_user = ?;
        ";
    }

    function get_sql_director_sign_in() {
        return "
            SELECT
                d.id_director,
                d.id_user,

                u.id_user,
                u.username,
                u.email,
                u.role_user,
                u.cpf,
                u.birth_date,
                u.photo,
                u.description_user,
                u.id_phone,
                u.id_housing,

                h.id_housing,
                h.cep,
                h.number_house,
                h.additional_information,
                h.id_address,

                a.id_address,
                a.country,
                a.state,
                a.city,
                a.neighborhood,
                a.street,

                p.id_phone,
                p.international_dialling_code,
                p.local_dialling_code,
                p.number_phone

            FROM director AS d
                INNER JOIN users AS u ON d.id_user = u.id_user
                INNER JOIN housing AS h ON u.id_housing = h.id_housing
                INNER JOIN address AS a ON h.id_address = a.id_address
                INNER JOIN phone AS p ON u.id_phone = p.id_phone

            WHERE u.id_user = ?;
        ";
    }

    function get_id_address(){
        return "
            SELECT id_address 
            FROM housing 
            WHERE id_housing = ?; 
        ";
    }

    //=========================
    //  CREATION FUNCTIONS
    //=========================

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

    //=========================
    //  UPDATE FUNCTIONS
    //=========================

    function update_user(){
        return "
            UPDATE users
            SET username = ?, email = ?, password_hash = ?, birth_date = ?, description_user = ?
            WHERE id_user = ?;
        ";
    }

    function update_phone(){
        return "
            UPDATE phone
            SET international_dialling_code = ?, local_dialling_code = ?, number_phone = ?
            WHERE id_phone = ?;
        ";
    }

    function update_housing(){
        return "
            UPDATE housing
            SET cep = ?, number_house = ?, additional_information = ?
            WHERE id_address = ?;
        ";
    }

    function update_address(){
        return "
            UPDATE address
            SET country = ?, state = ?, city = ?, neighborhood = ?, street = ?
            WHERE id_address = ?;
        ";
    }
?>

