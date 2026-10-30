<?php
    session_start();
    
    require_once __DIR__ . "/../repository/data_access_object/sign_in_repository.php";

    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"];

    if(!$email){
        $_SESSION["sign_in_error"] = "Invalid E-mail";
        header("Location: ../../pages/register/sign_in.php");
        exit;
    }

    try {
        $user_data = get_user($email, $password);
        $_SESSION["user_data"] = $user_data;

        if (isset($_POST["remember"])) {
            $_SESSION["expiration_time"] = time() + (7 * 24 * 60 * 60);
        }
        else {
            $_SESSION["expiration_time"] = time() + (24 * 60 * 60);
        }

        unset($_SESSION["sign_in_error"]);
        header("Location: ../../pages/main/main.php");
        exit();
    }
    catch (Exception $e) {

        if ($e->getMessage() == "User Not Found") {
            $_SESSION["sign_in_error"] = $e->getMessage();
        }
        else if ($e->getMessage() == "Password Invalid") {
            $_SESSION["sign_in_error"] = $e->getMessage();
        }
        else {
            $_SESSION["sign_in_error"] = "Server Error";
        }

        header("Location: ../../pages/register/sign_in.php");
        exit();
    }
?>