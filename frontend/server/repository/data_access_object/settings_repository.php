<?php

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries/update_queries.php";
    require_once __DIR__ . "/../queries/delete_queries.php";

    function edit_account(array $user, String $user_role){

        $connection = user_connection($user_role);

        try{
            if ($user_role == "RESEARCHER") {
                
                $account_statement = $connection->prepare(update_researcher());
                $account_statement->bind_param(
                    "sssssi",
                    $user["username"],
                    $user["birth_date"],
                    $user["description_user"],
                    $user["photo"],
                    $user["institute"],
                    $user["id_user"]
                );
                $account_statement->execute();
            }
            else {

                $account_statement = $connection->prepare(update_user());
                $account_statement->bind_param(
                    "ssssi",
                    $user["username"],
                    $user["birth_date"],
                    $user["description_user"],
                    $user["photo"],
                    $user["id_user"]
                );
                $account_statement->execute();
            }
        }
        catch (Exception) {
            
            throw new Exception("User could not be Updated");
        }
    }

    function edit_email(array $email_list, String $user_role) {

        
    }

    function edit_password(array $password_list, String $user_role) {

    }

    function edit_phone(array $phone_list, $user_role) {

    }

    function remove_user(array $delete_list, $user_role) {

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
                $address["id_address"]
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

    function edit_notifications() {

    }
?>