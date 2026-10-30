<?php
    session_start();

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries.php";

    function edit_account(array $user, array $phone, String $user_role){

        $connection = user_connection($user_role);

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
                $phone["id_phone"]
            );
            $phone_statement->execute();
            $phone_statement->close();

            $connection->commit();
        }
        catch (Exception) {
            
            $connection->rollback();
            throw new Exception("User could not be Updated");
        }
    }

    function edit_address(array $address, String $user_role) {
        
        $connection = user_connection($user_role);

        try {
            $connection->begin_transaction();
            
            $address_statement = $connection->prepare(update_address());
            $address_statement->bind_param(
                "sssssi",
                $address["country"],
                $address["state"],
                $address["city"],
                $address["neighborhood"],
                $address["street"],
                $address["is_address"]
            );
            $address_statement->execute();
            $address_statement->close();


            $housing_statement = $connection->prepare(update_housing());
            $housing_statement->bind_param(
                "sisi",
                $address["cep"],
                $address["number_house"],
                $address["additional_information"],
                $address["id_housing"]
            );
            $housing_statement->execute();
            $housing_statement->close();

            $connection->commit();
        }
        catch (Exception) {
            
            $connection->rollback();
            throw new Exception("User Address could not be Updated");
        }
    }
?>