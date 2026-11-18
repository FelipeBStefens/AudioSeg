<?php
    session_start();

    require_once __DIR__ . "/../repository/data_access_object/police_station_repository.php";

    $action = $_POST["action"];
    $role_user = $_SESSION["user_data"]["role_user"];

    switch($action){
        
        case "police":
            $id_policeman = $_POST["id_policeman"];

            try {
                
                remove_policeman($role_user, $id_policeman);
                header("Location: ../../pages/strict/police_station.php");
                exit();
            }
            catch(Exception $e){
                header("Location: ../../pages/strict/police_station.php");
                exit();
            }
        
        case "create_policeman":
            
            $username = $_POST["policeman_username"];
            $email = $_POST["policeman_email"];
            $password = $_POST["policeman_password"];
            $cpf = $_POST["policeman_cpf"];
            $phone = $_POST["delegate_phone"];
            $birth_date = $_POST["policeman_birth_date"];
            $badge = $_POST["policeman_badge"];
            $start_period = $_POST["policeman_start_period"];
            $end_period = $_POST["policeman_end_period"];
            $status = $_POST["status"];
    
            break;
        
        case "create_delegate":

            $username = $_POST["delegate_username"];
            $email = $_POST["delegate_email"];
            $password = $_POST["delegate_password"];
            $cpf = $_POST["delegate_cpf"];
            $phone = $_POST["delegate_phone"];
            $birth_date = $_POST["delegate_birth_date"];
            $start_period = $_POST["policeman_start_period"];
            $end_period = $_POST["policeman_end_period"];


            break;

        case "station":

            $id_station = $_POST["id_station"];

            try {

                delete_station($role_user, $id_station);
                header("Location: ../../pages/strict/police_station.php");
                exit();
            }
            catch(Exception $e) {
                echo "deu bosta aq";
                //header("Location: ../../pages/strict/police_station.php");
                exit();
            }
    }
?>