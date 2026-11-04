<?php
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    require_once __DIR__ . "/../repository/data_access_object/settings_repository.php";
    require_once __DIR__ . "/../repository/upload_photo.php";

    $action = $_POST["action"];
    $user = $_SESSION["user_data"];
    $user_role = $user["role_user"];

    switch($action){
         
        case 'account': 
            try {

                $filepath = $user["photo"];
                $old_photo = $user["photo"];

                if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] !== UPLOAD_ERR_NO_FILE) {
                    $filepath = upload_photo($_FILES["photo"], $user["id_user"]);
                }

                $user_list = [
                    "id_user" => $user["id_user"],
                    "username" => trim($_POST["username"]),  
                    "birth_date" => $_POST["birth_date"], 
                    "description_user" => trim($_POST["description_user"]),
                    "photo" => $filepath
                ];

                if ($user_role == "RESEARCHER") {
                    $user_list["institute"] = trim($_POST["institute"]);
                }

                edit_account($user_list, $user_role);

                if ($filepath !== $old_photo) {

                    $oldPhotoPath = __DIR__ . "/../../" . $old_photo;

                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }

                $user["username"] = $user_list["username"];
                $user["birth_date"] = $user_list["birth_date"];
                $user["description_user"] = $user_list["description_user"];
                $user["photo"] = $user_list["photo"];

                if ($user_role == "RESEARCHER") {
                    $user["institute"] = $user_list["institute"];
                }

                $_SESSION["user_data"] = $user;

                unset($_SESSION["settings_error"]);
                header("Location: ../../pages/main/settings.php");
                exit();
            }
            catch(Exception $e) {

                if ($e->getMessage() == "User could not be Updated") {
                    $_SESSION["settings_error"] = $e->getMessage();
                }
                else if ($e->getMessage() == "Server could not load File") {
                    $_SESSION["settings_error"] = $e->getMessage();
                }
                else {
                    $_SESSION["settings_error"] = "Server Error";
                }

                header("Location: ../../pages/main/settings.php");
                exit();
            }

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
        
        case 'change_email':
            $email_list = [
                "id_user" => $user["id_user"],
                "email" => $_POST["new_email"],
                "current_password" => $_POST["current_password"]
            ];

            if(!$email_list["email"] != $_POST["confirm_email"]){
                //ARRUMAR ISSO AQUI
                throw new Exception("Different Emails!");
                exit();
            }

            try{
                edit_email($email_list, $user_role);

                $user["email"] = $email_list["email"];
                $_SESSION["user_data"] = $user;

                unset($_SESSION["settings_error"]);
                header("Location: ../../pages/main/settings.php");
                exit();
            }
            catch(Exception $e) {
                
                if ($e->getMessage() == "User Email could not be Updated") {
                    $_SESSION["settings_error"] = $e->getMessage();
                }
                else {
                    $_SESSION["settings_error"] = "Server Error";
                }

                header("Location: ../../pages/main/settings.php");
                exit();
            }
            
            break;

        case 'change_phone':
            break;

        case 'change_password':
            break;
        
        case 'delete_account':
            break;
            
        default:
            break;
    }
?>