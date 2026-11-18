<?php
    session_start();

    require_once __DIR__ . "/../repository/data_access_object/real_time_repository.php";

    $role_user = $_SESSION["user_data"]["role_user"];
    $id_gunshot = $_POST["public_gunshot"];

    try {
        make_it_public($role_user, $id_gunshot);
        
        header("Location: /../../pages/strict/real_time_map.php");
        exit();
    } 
    catch (Exception) {
        
    header("Location: /../../pages/strict/real_time_map.php");
        exit();
    }
?>