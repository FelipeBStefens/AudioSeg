<?php

    session_start();

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries.php";

    function add_researcher(String $username, String $email, String $password, String $role) {

        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        
        $connection = researcher_connect();
        $connection->begin_transaction();

        try {
            
            $phone_statement = $connection->prepare(create_phone());
            $phone_statement->bind_param("iii");
            $phone_statement->execute();
            $id_phone = $connection->insert_id;
            $phone_statement->close();

            $address_statement = $connection->prepare(create_address());
            $address_statement->bind_param("sssss");
            $address_statement->execute();
            $id_address = $connection->insert_id;
            $address_statement->close();

            $housing_statement = $connection->prepare(create_housing());
            $housing_statement->bind_param("sisi");
            $housing_statement->execute();
            $id_housing = $connection->insert_id;
            $housing_statement->close();

            $user_statement = $connection->prepare(create_user());
            $user_statement->bind_param("");
            $user_statement->execute();
            $id_user = $connection->insert_id;
            $user_statement->close();

            $researcher_statement = $connection->prepare(create_researcher());
            $researcher_statement->bind_param("si");
            $researcher_statement->execute();
            $researcher_statement->close();
        }
        catch (Exception $e) {
            $connection->rollback();
            echo $e->getMessage();
        }
    }
?>