<?php

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries/view_queries.php";

    function get_shots(String $role_user) {
        
        $connection = user_connection($role_user);
        $statement = $connection->prepare(get_public_shots());
        $statement->execute();
        $query = $statement->get_result();

        $all_public_shots = [];

        while($shot = $query->fetch_assoc()) {
            array_push($all_public_shots, $shot);
        } 

        return $all_public_shots;
    }  
?>