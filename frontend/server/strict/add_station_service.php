<?php
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . "/../repository/data_access_object/police_station_repository.php";

    $role_user = $_SESSION["user_data"]["role_user"];

    $station_info = [
        "name" => $_POST["name_police_station"],
        "country" => $_POST["country"],
        "state" => $_POST["state"],
        "city" => $_POST["city"],
        "neighborhood" => $_POST["neighborhood"],
        "street" => $_POST["street"],
        "cep" => $_POST["cep"],
        "number_house" => $_POST["number_house"],
        "additional_information" => $_POST["additional_information"]
    ];
                
    create_police_station($role_user, $station_info);

    header("Location: ../../pages/strict/police_station.php");
    exit();
?>