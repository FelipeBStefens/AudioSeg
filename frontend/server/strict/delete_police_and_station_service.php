<?php
    session_start();

    require_once __DIR__ . "/../repository/data_access_object/police_station_repository.php";

    $action = $_POST["action"];
    $role_user = $_SESSION["user_data"]["role_user"];

    switch($action){
        case "police":
            $id_policeman = $_POST["id_policeman"];

            try{
                
                remove_policeman($role_user, $id_policeman);
                header("Location: ../../pages/strict/police_station.php");
                exit();

            }catch(Exception $e){
                header("Location: ../../pages/strict/police_station.php");
                exit();
            }

            break;

        case "station":

            $id_station = $_POST["id_station"];

            try{

                delete_station($role_user, $id_station);
                header("Location: ../../pages/strict/police_station.php");
                exit();

            }catch(Exception $e){
                echo "deu bosta aq";
                //header("Location: ../../pages/strict/police_station.php");
                exit();
            }

            break;
    }

?>