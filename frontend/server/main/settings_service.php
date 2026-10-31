<?php
    session_start();

    require_once __DIR__ . "/../repository/data_access_object/settings_repository.php";

    $action = $_POST["action"];
    $user = $_SESSION["user_data"];
    $user_role = $user["role_user"];

    switch($action){
        
        case 'account':
            $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
            $password = $_POST["password"];

            if(!$email) {
                $_SESSION["sign_in_error"] = "Invalid E-mail";
                header("Location: ../../pages/main/settings.php");
                exit;
            }
            
            $user_list = [
                "id_user" => $user["id_user"],
                "username" => trim($_POST["username"]), 
                "email" => $email, 
                "password" => $password, 
                "birth_date" => $_POST["birth_date"], 
                "description_user" => trim($_POST["description"])
            ];

            $phone = preg_replace("/\D/", '', $_POST["phone"]);
            $phone_list = [
                "id_phone" => $user["id_phone"],
                "international_dialling_code" => substr($phone, 0, 2),
                "local_dialling_code" => substr($phone, 2, 2),
                "number_phone" => substr($phone, 4, 5) . "-" . substr($phone, 9, 4)
            ];

            try {
                edit_account($user_list, $phone_list, $user_role);
            }
            catch(Exception) {
            }
            break;

        case 'address':
            $address_list = [
                "id_address" => $user["id_address"],
                "id_housing" => $user["id_housing"],
                "country" => trim($_POST["country"]), 
                "state" => trim($_POST["state"]), 
                "city" => trim($_POST["city"]), 
                "neighborhood" => trim($_POST["neighborhood"]), 
                "street" => trim($_POST["street"]), 
                "cep" => $_POST["cep"], 
                "number_house" => trim($_POST["number_house"]), 
                "additional_information" => trim($_POST["additional_information"])
            ];

            try {
                edit_address($address_list, $user_role);

                $user["country"] = $address_list["country"];
                $user["state"] = $address_list["state"];
                $user["city"] = $address_list["city"];
                $user["neighborhood"] = $address_list["neighborhood"];
                $user["street"] = $address_list["street"];
                $user["cep"] = $address_list["cep"];
                $user["number_house"] = $address_list["number_house"];
                $user["additional_information"] = $address_list["additional_information"];
                $_SESSION["user_data"] = $user;

                unset($_SESSION["settings_error"]);
                header("Location: ../../pages/main/settings.php");
                exit();
            }
            catch(Exception $e) {
                
                if ($e->getMessage() == "User Address could not be Updated") {
                    $_SESSION["settings_error"] = $e->getMessage();
                }
                else {
                    $_SESSION["settings_error"] = "Server Error";
                }

                header("Location: ../../pages/main/settings.php");
                exit();
            }
        
        case 'notifications':
            break;

        default:
            break;
    }
?>