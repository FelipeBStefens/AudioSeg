<?php

    session_start();

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries.php";

    function edit_account(array $user, array $phone){

        $connection = choose_user_connection($_SESSION["user_data"]["role_user"]);

        try{
            $connection->begin_transaction();

            $hash_password = password_hash($user["password"], PASSWORD_DEFAULT);
            $user_statement = $connection->prepare(update_user());
            $user_statement->bind_param(
                "sssssi",
                $user["username"],
                $user["email"],
                $hash_password,
                $user["birth_date"],
                $user["description_user"],
                $user["id_user"]
            );
            $user_statement->execute();
            $user_statement->close();


            $phone_statement = $connection->prepare(update_phone());
            $phone_statement->bind_param(
                "iisi",
                $phone["international_dialling_code"],
                $phone["local_dialling_code"], 
                $phone["number_phone"],
                $user["id_phone"]
            );
            $phone_statement->execute();
            $phone_statement->close();

            $connection->commit();

        }catch (Exception) {
            
            $connection->rollback();
            throw new Exception("Credential Error, User Not Updated");
        }

    }

    function edit_address(array $address, int $id_housing){
        $connection = choose_user_connection($_SESSION["user_data"]["role_user"]);

        try{

            $connection->begin_transaction();

            $id_address_statement = $connection->prepare(get_id_address());
            $id_address_statement->bind_param("i", $id_housing);
            $id_address_statement->execute();

            $result = $id_address_statement->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $id_address = $row['id_address']; 
            } else {
                $id_address = null;
            }

            $id_address_statement->close();
            
            $address_statement = $connection->prepare(update_address());
            $address_statement->bind_param(
                "sssssi",
                $address["country"],
                $address["state"],
                $address["city"],
                $address["neighborhood"],
                $address["street"],
                $id_address
            );
            $address_statement->execute();
            $address_statement->close();


            $housing_statement = $connection->prepare(update_housing());
            $housing_statement->bind_param(
                "sisi",
                $address["cep"],
                $address["number_house"],
                $address["additional_information"],
                $id_address
            );
            $housing_statement->execute();
            $housing_statement->close();

            $connection->commit();

        }catch (Exception) {
            
            $connection->rollback();
            throw new Exception("Credential Error, User Not Updated");
        }
    }

?>