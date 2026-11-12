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
?>