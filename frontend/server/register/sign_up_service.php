<?php
    
    session_start();

    require_once __DIR__ . "/../repository/data_access_object/sign_up_repository.php";

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $birth_date = $_POST["birth_date"];
    $cpf = $_POST["cpf"];
    $institute = $_POST["institute"];

    $user_list = [$username, $email, $password, $cpf, $birth_date, $institute];

    $phone_list = explode(" ", $_POST["phone"]);
    $idc = $phone_list[0];
    $ldc = $phone_list[1];
    $phone_number = $phone_list[2];

    $phone_list = [$idc, $ldc, $phone_number];

    $country = $_POST["country"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $neighborhood = $_POST["neighborhood"];
    $street = $_POST["street"];
    $zipcode = $_POST["zipcode"];
    $number = $_POST["number"];
    $complement = $_POST["complement"];

    $address_list = [$country, $state, $city, $neighborhood, $street, $zipcode, $number, $complement];

    
    add_researcher($user_list, $phone_list, $address_list);
    
    header("Location: ../../pages/pages.html");
    exit();
?>