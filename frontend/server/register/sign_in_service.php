<?php

    session_start();
    
    require_once __DIR__ . "/../repository/data_access_object/sign_in_repository.php";

    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        $response = get_user($email, $password);
        echo $response;

        header("Location: ../../pages/pages.html");
        exit();
    }
    catch (Exception $e) {

        if ($e->getMessage() == "User Not Found") {

            # To do
        }
        else if ($e->getMessage() == "Password Invalid") {

            # To do
        }
        else {

            # To do
        }
    }
?>