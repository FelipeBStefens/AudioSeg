<?php

    session_start();

    require_once __DIR__ . "/../repository/data_access_object/real_time_repository.php";

    $role_user = $_SESSION["user_data"]["role_user"];

    try {
        $public_shots = get_real_time_shots($role_user);
        echo json_encode(["shootings" => $public_shots]);
        exit();
    } 
    catch (Exception $e) {

        http_response_code(500);
        echo json_encode(["error" => "Server Error"]);
        exit();
    }
?>