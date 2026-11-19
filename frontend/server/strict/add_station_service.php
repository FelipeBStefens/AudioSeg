<?php
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . "/../repository/data_access_object/police_station_repository.php";

    $role_user = $_SESSION["user_data"]["role_user"];

    $name_police_station = $_POST["name_police_station"];
    $country = $_POST["country"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $neighborhood = $_POST["neighborhood"];
    $street = $_POST["street"];
    $cep = $_POST["cep"];
    $number_house = $_POST["number_house"];
    $additional_information = $_POST["additional_information"];

    $station_info = [
        "name" => $name_police_station,
        "country" => $country,
        "state" => $state,
        "city" => $city,
        "neighborhood" => $neighborhood,
        "street" => $street,
        "cep" => $cep,
        "number_house" => $number_house,
        "additional_information" => $additional_information
    ];

    try {
                
        create_police_station($role_user, $station_info);
        echo "CHEGUEI AQUI";
        header("Location: ../../pages/strict/police_station.php");
        exit();
    }
    catch(Exception $e){
        header("Location: ../../pages/strict/police_station.php");
        exit();
    }
?>