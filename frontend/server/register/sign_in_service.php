<?php

    session_start();
    require_once __DIR__ . "../repository/sign_in_repository.php";

    $email = $_POST["email"];
    $password = $_POST["password"];

    $response = get_user($email, $password);
    echo $response;

    header("Location: ../../pages/pages.html");
    exit();
?>