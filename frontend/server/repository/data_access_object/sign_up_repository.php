<?php

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries.php";

    function add_researcher(array $user, array $phone, array $address) {

        $connection = researcher_connect();

        try {
            $connection->begin_transaction();

            $phone_statement = $connection->prepare(create_phone());
            $phone_statement->bind_param(
                "iis",
                $phone["international_dialling_code"],
                $phone["local_dialling_code"], 
                $phone["number_phone"]
            );
            $phone_statement->execute();
            $id_phone = $connection->insert_id;
            $phone_statement->close();


            $address_statement = $connection->prepare(create_address());
            $address_statement->bind_param(
                "sssss",
                $address["country"],
                $address["state"],
                $address["city"],
                $address["neighborhood"],
                $address["street"],
            );
            $address_statement->execute();
            $id_address = $connection->insert_id;
            $address_statement->close();


            $housing_statement = $connection->prepare(create_housing());
            $housing_statement->bind_param(
                "sisi",
                $address["cep"],
                $address["number_house"],
                $address["additional_information"],
                $id_address
            );
            $housing_statement->execute();
            $id_housing = $connection->insert_id;
            $housing_statement->close();


            $hash_password = password_hash($user["password"], PASSWORD_DEFAULT);
            $user_statement = $connection->prepare(create_user());
            $user_statement->bind_param(
                "sssssii",
                $user["username"],
                $user["email"],
                $hash_password,
                $user["cpf"],
                $user["birth_date"],
                $id_phone,
                $id_housing
            );
            $user_statement->execute();
            $id_user = $connection->insert_id;
            $user_statement->close();


            $researcher_statement = $connection->prepare(create_researcher());
            $researcher_statement->bind_param(
                "si",
                $user["institute"],
                $id_user
            );
            $researcher_statement->execute();
            $researcher_statement->close();

            $connection->commit();
        }
        catch (Exception $e) {
            $connection->rollback();
            echo $e->getMessage();
            throw new Exception("User not created");
        }
    }
?>