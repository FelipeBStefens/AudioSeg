<?php
    session_start();

    require_once __DIR__ . "/../repository/data_access_object/police_station_repository.php";

    $action = $_POST["action"];
    $role_user = $_SESSION["user_data"]["role_user"];

    switch($action){
        
        case "police":

            $list_id = [
                "id_user" => $_POST["id_user"],
                "id_address" => $_POST["id_address"],
                "id_phone" => $_POST["id_phone"],
                "id_notification" => $_POST["id_notification"]
            ];
            
            remove_policeman($role_user, $list_id);          
            
            header("Location: ../../pages/strict/police_station.php");
            exit();

        
        case "create_policeman":
            
            $password = $_POST["policeman_password"];
            $id_police_station = $_POST["id_police_station"];

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $phone = preg_replace("/\D/", '', $_POST["policeman_phone"]);
            $phone_list = [
                "international_dialling_code" => substr($phone, 0, 2),
                "local_dialling_code" => substr($phone, 2, 2),
                "number_phone" => substr($phone, 4, 5) . "-" . substr($phone, 9, 4)
            ];

            $user_list = [
                "username" => $_POST["policeman_username"],
                "email" => $_POST["policeman_email"],
                "password" => $password_hash,
                "cpf" => $_POST["policeman_cpf"],
                "birth_date" => $_POST["policeman_birth_date"],
            ];

            $policeman_list = [
                "badge" => $_POST["policeman_badge"],
                "start_period" => $_POST["policeman_start_period"],
                "end_period" => $_POST["policeman_end_period"],
                "status" => $_POST["status"]
            ];
    
            create_policeman($role_user, $phone_list, $user_list, $policeman_list, $id_police_station);

            header("Location: ../../pages/strict/police_station.php");
            exit(); 
        

        case "create_delegate":

            $password = $_POST["delegate_password"];
            $id_police_station = $_POST["id_police_station"];

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $phone = preg_replace("/\D/", '', $_POST["delegate_phone"]);
            $phone_list = [
                "international_dialling_code" => substr($phone, 0, 2),
                "local_dialling_code" => substr($phone, 2, 2),
                "number_phone" => substr($phone, 4, 5) . "-" . substr($phone, 9, 4)
            ];

            $user_list = [
                "username" => $_POST["delegate_username"],
                "email" => $_POST["delegate_email"],
                "password" => $password_hash,
                "cpf" => $_POST["delegate_cpf"],
                "birth_date" => $_POST["delegate_birth_date"],
            ];

            $delegate_list = [
                "start_period" => $_POST["delegate_start_period"],
                "end_period" => $_POST["delegate_end_period"]
            ];

            create_delegate($role_user, $phone_list, $user_list, $delegate_list, $id_police_station);
            header("Location: ../../pages/strict/police_station.php");
            exit(); 

            
        case "station":

            $id_station = $_POST["id_station"];
            $id_address = $_POST["id_address"];
            $list_policemen = get_policemen_from_station($id_station, $role_user);
                   
            delete_station($role_user, $id_station, $id_address, $list_policemen);
            header("Location: ../../pages/strict/police_station.php");
            exit();
    }
?>