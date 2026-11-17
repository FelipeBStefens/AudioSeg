<?php

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries/view_queries.php";
    require_once __DIR__ . "/../queries/update_queries.php";

    function get_real_time_shots(String $role_user) {
        
        $connection = user_connection($role_user);
        $statement = $connection->prepare(get_all_shots());
        $statement->execute();
        $query = $statement->get_result();

        $all_public_shots = [];

        while($shot = $query->fetch_assoc()) {
            array_push($all_public_shots, $shot);
        } 

        return $all_public_shots;
    }

    function make_it_public(String $role_user, int $id_gunshot){

        try{
            $connection = user_connection($role_user);
            $statement = $connection->prepare(make_public());
            $statement->bind_param("i", $id_gunshot);
            $statement->execute();
        }catch(Exception $e){
            echo $e->getMessage();
            throw new Exception("Could not make it public!");
        }
    }
?>