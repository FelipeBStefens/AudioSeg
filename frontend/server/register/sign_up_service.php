<?php
    
    session_start();

    require_once __DIR__ . "/../repository/data_access_object/sign_up_repository.php";

    $user_list = [
        "username" => $_POST["username"], 
        "email" => $_POST["email"], 
        "password" => $_POST["password"], 
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
    
        header("Location: ../../pages/pages.html");
        exit();
    }
    catch (Exception $e) {

        if ($e->getMessage() == "User not created") {

            echo $e->getMessage();
        }
        else {
            
            echo $e->getMessage();
        }
    }
?>