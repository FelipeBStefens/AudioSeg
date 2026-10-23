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

    $phone_list = explode(" ", $_POST["phone"]);
    $phone_list = [
        "international_dialling_code" => $phone_list[0], 
        "locall_dialling_code" => $phone_list[1], 
        "number_phone" => $phone_list[2]
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

    add_researcher($user_list, $phone_list, $address_list);
    
    header("Location: ../../pages/pages.html");
    exit();
?>