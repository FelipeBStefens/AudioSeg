<?php

    session_start();

    require_once __DIR__ . "/../repository/data_access_object/settings_repository.php";

    $action = $_POST["action"];

    switch($action){
        case 'account':
            $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
            $password = $_POST["password"];

            if(!$email){
                $_SESSION["sign_in_error"] = "Invalid E-mail";
                header("Location: ../../pages/main/settings.php");
                exit;
            }
            
            $user_list = [
                "username" => trim($_POST["username"]), 
                "email" => $email, 
                "password" => $password, 
                "birth_date" => $_POST["birth_date"], 
                "description_user" => trim($_POST["description"]),
                "id_user" => $_SESSION["id_user"]
            ];

            $phone = preg_replace("/\D/", '', $_POST["phone"]);
            $phone_list = [
                "international_dialling_code" => substr($phone, 0, 2),
                "local_dialling_code" => substr($phone, 2, 2),
                "number_phone" => substr($phone, 4, 5) . "-" . substr($phone, 9, 4)
            ];

            try{
                edit_account($user_list, $phone_list);
            }catch(Exception){
                if ($e->getMessage() == "Credential Error, User not Edited") {
                    $_SESSION["edition_error"] = $e->getMessage();
                }
                else {
                    $_SESSION["edition_error"] = "Server Error";
                }

                exit();
            }

            break;

        case 'address':
            $address_list = [
                "country" => trim($_POST["country"]), 
                "state" => trim($_POST["state"]), 
                "city" => trim($_POST["city"]), 
                "neighborhood" => trim($_POST["neighborhood"]), 
                "street" => trim($_POST["street"]), 
                "cep" => $_POST["cep"], 
                "number_house" => trim($_POST["number_house"]), 
                "additional_information" => trim($_POST["additional_information"])
            ];

            try{
                //Pegar o id_housing
                edit_address($address_list, $id_housing);
            }catch(Exception){
                if ($e->getMessage() == "Credential Error, User not Edited") {
                    $_SESSION["edition_error"] = $e->getMessage();
                }
                else {
                    $_SESSION["edition_error"] = "Server Error";
                }

                exit();
            }
            break;
            
        case 'account':
            //code
            break;

        default:
            break;
    }

?>