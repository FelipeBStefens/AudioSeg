<?php

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries.php";

    function add_researcher($user, $phone, $address) {

        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        
        $connection = researcher_connect();
        $connection->begin_transaction();

        try {
            
            $phone_statement = $connection->prepare(create_phone());

            $phone_statement->bind_param(
                "iis",
                $phone[0], 
                $phone[1], 
                $phone[2]
            );

            $phone_statement->execute();
            $id_phone = $connection->insert_id;
            $phone_statement->close();

            $address_statement = $connection->prepare(create_address());

            $address_statement->bind_param(
                "sssss",
                $address[0],
                $address[1],
                $address[2],
                $address[3],
                $address[4],
            );

            $address_statement->execute();
            $id_address = $connection->insert_id;
            $address_statement->close();

            $housing_statement = $connection->prepare(create_housing());

            $housing_statement->bind_param(
                "sisi",
                $address[5],
                $address[6],
                $address[7],
                $id_address
            );

            $housing_statement->execute();
            $id_housing = $connection->insert_id;
            $housing_statement->close();

            $user_statement = $connection->prepare(create_user());

            $user_statement->bind_param(
                "sssssii",
                $user[0],
                $user[1],
                $user[2],
                $user[3],
                $user[4],
                $id_phone,
                $id_housing
            );

            $user_statement->execute();
            $id_user = $connection->insert_id;
            $user_statement->close();

            $researcher_statement = $connection->prepare(create_researcher());

            $researcher_statement->bind_param(
                "si",
                $user[5],
                $id_user
            );

            $researcher_statement->execute();
            $researcher_statement->close();
        }
        catch (Exception $e) {
            $connection->rollback();
            echo $e->getMessage();
        }
    }
?>