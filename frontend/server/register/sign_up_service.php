<?php
    session_start();
    require_once __DIR__ . "../repository/sign_in_repository.php";

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $birth_date = $_POST["birth_date"];
    $cpf = $_POST["cpf"];

    $phone_list = explode(" ", $_POST["phone"]);
    $idc = $phone_list[0];
    $ldc = $phone_list[1];
    $phone_number = $phone_list[2];


    $zipcode = $_POST["zipcode"];
    $country = $_POST["country"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $neighborhood = $_POST["neighborhood"];
    $street = $_POST["street"];
    $number = $_POST["number"];
    $complement = $_POST["complement"];


    // $novo_id = $conexao->insert_id;
    
    echo "Sign Up"
?>