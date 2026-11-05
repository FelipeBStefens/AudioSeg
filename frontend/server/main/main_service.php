<?php
    
    require_once __DIR__ . "/../repository/data_access_object/main_repository.php";
    require_once __DIR__ . "/shoot_service.php";

    $role_user = $_SESSION["user_data"]["role_user"];

    $public_shots = get_shots($role_user);
    $index = 1;

    foreach($public_shots as $shot) {
        create_shoot($index, $shot);
        $index += 1;
    }
?>