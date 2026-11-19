<?php

    function get_all_researchers() {
        return "
            SELECT 
                r.id_researcher,
                r.institute, 
                r.expiration_date,

                u.id_user,  
                u.username, 
                u.email, 
                u.cpf, 
                u.birth_date, 
                u.photo, 
                u.description_user,

                h.id_housing,
                h.cep,
                h.number_house,
                h.additional_information,

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

            FROM address AS a
                INNER JOIN housing AS h ON a.id_address = h.id_address
                INNER JOIN users AS u ON h.id_housing = u.id_housing
                INNER JOIN phone AS p ON u.id_phone = p.id_phone 
                INNER JOIN researcher AS r ON u.id_user = r.id_user;
        ";
    }


    function get_all_police_stations(){
        return "
        SELECT * 
        FROM police_station ps
            INNER JOIN housing h ON ps.id_housing = h.id_housing
            INNER JOIN address a ON h.id_address = a.id_address;
        ";
    }

    
    function get_all_policemen_from_sation(){
        return "
            SELECT
                
                p.id_policeman,
                p.badge,
                p.status_policeman,
                DATE_FORMAT(p.start_period, '%H:%i') AS start_period,
                DATE_FORMAT(p.end_period, '%H:%i') AS end_period,
                p.id_police_station,
                
                u.id_user,
                u.username,
                u.email,
                u.role_user,
                u.photo,

                a.id_address,
                h.id_housing,
                ph.id_phone,
                n.id_notification

            FROM policeman p 
                INNER JOIN users u ON p.id_user = u.id_user
                INNER JOIN housing AS h ON u.id_housing = h.id_housing
                INNER JOIN address AS a ON h.id_address = a.id_address
                INNER JOIN phone AS ph ON u.id_phone = ph.id_phone
                INNER JOIN notification AS n ON u.id_notification = n.id_notification

            WHERE p.id_police_station = ?;
        ";
    }

    function get_station_delegates() {
        return "
            SELECT u.id_user, h.id_address, u.id_phone, u.id_notification
            FROM delegate AS d
                INNER JOIN users AS u ON u.id_user = d.id_user
                INNER JOIN housing AS h ON h.id_housing = u.id_housing
            WHERE d.id_police_station = ?;
        ";
    }
?>