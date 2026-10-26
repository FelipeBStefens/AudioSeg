<?php
    
    session_start();

    require_once __DIR__ . "/../repository/data_access_object/sign_up_repository.php";
    require_once __DIR__ . "/../repository/data_access_object/sign_in_repository.php";

    $email = $_POST["email"];
    $password = $_POST["password"];
    
    $user_list = [
        "username" => $_POST["username"], 
        "email" => $email, 
        "password" => $password, 
        "cpf" => $_POST["cpf"], 
        "birth_date" => $_POST["birth_date"], 
        "institute" => $_POST["institute"]
    ];

    $phone = preg_replace("/\D/", '', $_POST["phone"]);
    $phone_list = [
        "international_dialling_code" => substr($phone, 0, 2),
        "local_dialling_code" => substr($phone, 2, 2),
        "number_phone" => substr($phone, 4, 5) . "-" . substr($phone, 9, 4)
    ];

    $address_list = [
        "country" => $_POST["country"], 
        "state" => $_POST["state"], 
        "city" => $_POST["city"], 
        "neighborhood" => $_POST["neighborhood"], 
        "street" => $_POST["street"], 
        "cep" => $_POST["cep"], 
        "number_house" => $_POST["number_house"], 
        "additional_information" => $_POST["additional_information"]
    ];

    try {
        add_researcher($user_list, $phone_list, $address_list);
        
        $user_data = get_user($email, $password); 
        $_SESSION["user_data"] = $user_data;

        unset($_SESSION["sign_up_error"]);
        header("Location: ../../pages/main/main.php");
        exit();
    }
    catch (Exception $e) {

        if ($e->getMessage() == "Credential Error, User not Created") {
            $_SESSION["sign_up_error"] = $e->getMessage();
        }
        else {
            $_SESSION["sign_up_error"] = "Server Error";
        }

        header("Location: ../../pages/register/sign_up.php");
        exit();
    }
?>