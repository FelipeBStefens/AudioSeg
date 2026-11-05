<?php

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries/update_queries.php";
    require_once __DIR__ . "/../queries/auth_queries.php";
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
        
        $auth_connection = auth_connect();
        $statement = $auth_connection->prepare(get_sql_auth());
        $statement->bind_param("s", $email_list["actual_email"]);
        $statement->execute();
        $query = $statement->get_result();

        $connection = user_connection($user_role);

        if ($query->num_rows == 1) {

            $auth = $query->fetch_assoc();

            if (password_verify($email_list["current_password"], $auth["password_hash"])) {
                
                try{
                    $connection->begin_transaction();
                    $email_statement = $connection->prepare(update_email());
                    $email_statement->bind_param("si", $email_list["email"], $_SESSION["user_data"]["id_user"]);

                    $email_statement->execute();
                    $email_statement->close();

                    $connection->commit();
                }
                catch (Exception) {
                    $connection->rollback();
                    throw new Exception("Email could not be Updated");
                }
            }
            else {
                throw new Exception("Password Invalid");
            }
        }
        else {
            throw new Exception("User Not Found");
        }
    }


    function edit_password(array $password_list, String $user_role) {
        
        $auth_connection = auth_connect();
        $statement = $auth_connection->prepare(get_sql_auth());
        $statement->bind_param("s", $password_list["email"]);
        $statement->execute();
        $query = $statement->get_result();

        $connection = user_connection($user_role);

        if ($query->num_rows == 1) {

            $auth = $query->fetch_assoc();

            if (password_verify($password_list["current_password"], $auth["password_hash"])) {
                
                try{
                    $hash_password = password_hash($password_list["password"], PASSWORD_DEFAULT);
                    $connection->begin_transaction();
                    $password_statement = $connection->prepare(update_password());
                    $password_statement->bind_param("si", $hash_password, $password_list["id_user"]);

                    $password_statement->execute();
                    $password_statement->close();

                    $connection->commit();
                }
                catch (Exception) {
                    $connection->rollback();
                    throw new Exception("Password could not be Updated");
                }
            }
            else {
                throw new Exception("Password Invalid");
            }
        }
        else {
            throw new Exception("User Not Found");
        }
    }


    function edit_phone(array $phone_list, String $user_role) {
        
        $auth_connection = auth_connect();
        $statement = $auth_connection->prepare(get_sql_auth());
        $statement->bind_param("s", $phone_list["email"]);
        $statement->execute();
        $query = $statement->get_result();

        $connection = user_connection($user_role);

        if ($query->num_rows == 1) {

            $auth = $query->fetch_assoc();

            if (password_verify($phone_list["current_password"], $auth["password_hash"])) {
                try{
                    $connection->begin_transaction();
                    
                    $phone_statement = $connection->prepare(update_phone());
                    $phone_statement->bind_param(
                        "iisi",
                        $phone_list["international_dialling_code"],
                        $phone_list["local_dialling_code"],
                        $phone_list["number_phone"],
                        $phone_list["id_user"]
                    );

                    $phone_statement->execute();
                    $phone_statement->close();

                    $connection->commit();
                }
                catch (Exception) {
                    $connection->rollback();
                    throw new Exception("Phone Number could not be Updated");
                }
            }
            else {
                throw new Exception("Password Invalid");
            }
        }
        else {
            throw new Exception("User Not Found");
        }
    }


    function remove_user(array $delete_list, String $user_role) {

        $auth_connection = auth_connect();
        $statement = $auth_connection->prepare(get_sql_auth());
        $statement->bind_param("s", $delete_list["email"]);
        $statement->execute();
        $query = $statement->get_result();

        $connection = user_connection($user_role);

        if ($query->num_rows == 1) {

            $auth = $query->fetch_assoc();
            
            if (password_verify($delete_list["current_password"], $auth["password_hash"])) {
                try {
                    $connection->begin_transaction();
                    $user_statement = $connection->prepare(delete_user());
                    $user_statement->bind_param("i", $delete_list["id_user"]);
                    $user_statement->execute();
                    $user_statement->close();

                    $address_statement = $connection->prepare(delete_address());
                    $address_statement->bind_param("i", $delete_list["id_address"]);
                    $address_statement->execute();
                    $address_statement->close();

                    $phone_statement = $connection->prepare(delete_phone());
                    $phone_statement->bind_param("i", $delete_list["id_phone"]);
                    $phone_statement->execute();
                    $phone_statement->close();

                    $connection->commit();
                }
                catch (Exception) {
                    $connection->rollback();
                    throw new Exception("User could not be Deleted");
                }
            }
            else {
                throw new Exception("Password Invalid");
            }
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