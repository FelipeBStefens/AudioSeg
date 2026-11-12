<?php

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries/get_all_queries.php";

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
?>