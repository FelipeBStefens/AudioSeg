<?php
    
    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries/view_queries.php";
    require_once __DIR__ . "/../queries/update_queries.php";
    require_once __DIR__ . "/../queries/get_all_queries.php";

    function get_police_stations(String $role_user){

        try{

            $connection = user_connection($role_user);
            $statement = $connection->prepare(get_all_police_stations());
            $statement->execute();
            $query = $statement->get_result();
            
            $all_police_stations = [];

            while($ps = $query->fetch_assoc()) {
                $policemen = get_policemen_from_station($ps["id_police_station"], $role_user);
                $ps["policemen"] = $policemen;
                array_push($all_police_stations, $ps);
            } 

            return $all_police_stations;

        }catch(Exception $e){
            throw new Exception("Could not find all police stations!");
        }

    }

    function get_policemen_from_station($id_station, $role_user){
        try{
            $connection = user_connection($role_user);
            $statement = $connection->prepare(get_all_policemen_from_sation());
            $statement->bind_param("i", $id_station);
            $statement->execute();
            $query = $statement->get_result();
                
            $all_policemen = [];

            while($policeman = $query->fetch_assoc()) {
                array_push($all_policemen, $policeman);
            }

            return $all_policemen;

        }catch(Exception $e){

            echo "<pre>";
            echo "ERRO ORIGINAL: " . $e->getMessage();
            echo "\nARQUIVO: " . $e->getFile();
            echo "\nLINHA: " . $e->getLine();
            echo "</pre>";

            throw $e;
        }
    }

?>