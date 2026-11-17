<?php

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries/get_all_queries.php";
    require_once __DIR__ . "/../queries/delete_queries.php";
    require_once __DIR__ . "/../queries/update_queries.php";

    function get_researchers(String $role_user) {
        
        $connection = user_connection($role_user);
        $statement = $connection->prepare(get_all_researchers());
        $statement->execute();
        $query = $statement->get_result();

        $all_researchers = [];

        while($researcher = $query->fetch_assoc()) {
            array_push($all_researchers, $researcher);
        } 

        return $all_researchers;
    }  

    function delete_researcher(String $role_user, int $id_user, int $id_address, int $id_phone) {
        
        $connection = user_connection($role_user);
        
        try {
            $connection->begin_transaction();
            
            $user_statement = $connection->prepare(delete_user());
            $user_statement->bind_param("i", $id_user);
            $user_statement->execute();
            $user_statement->close();

            $address_statement = $connection->prepare(delete_address());
            $address_statement->bind_param("i", $id_address);
            $address_statement->execute();
            $address_statement->close();

            $phone_statement = $connection->prepare(delete_phone());
            $phone_statement->bind_param("i", $id_phone);
            $phone_statement->execute();
            $phone_statement->close();

            $connection->commit();
        }
        catch(Exception) {
            throw new Exception("Could not delete the researcher");
        }
    }

    function update_expiration_researcher(String $role_user, int $id_researcher, String $expiration_date) {

        try {
            $connection = user_connection($role_user);
            $statement = $connection->prepare(update_expiration_date());
            $statement->bind_param("si", $expiration_date, $id_researcher);
            $statement->execute();
        }
        catch (Exception) {
            throw new Exception("Could not update the researcher");
        }
    }
?>