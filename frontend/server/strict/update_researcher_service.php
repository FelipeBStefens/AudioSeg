<?php
    
    session_start();

    require_once __DIR__ . "/../repository/data_access_object/show_researcher_repository.php";

    $action = $_POST["action"];
    $role_user = $_SESSION["user_data"]["role_user"];

    switch($action) {

        case "delete":
            try {
                $id_user = $_POST["id_user"];
                $id_address = $_POST["id_address"];
                $id_phone = $_POST["id_phone"];
                
                delete_researcher($role_user, $id_user, $id_address, $id_phone);
                
                unset($_SESSION["researcher_error"]);
                header("Location: ../../pages/strict/researcher_settings.php");
                exit();
            }
            catch (Exception $e) {
                
                if ($e->getMessage() == "Could not delete the researcher") {
                    $_SESSION["researcher_error"] = $e->getMessage();
                }
                else {
                    $_SESSION["researcher_error"] = "Server Error";
                }

                header("Location: ../../pages/strict/researcher_settings.php");
                exit();
            }
        
        case "update":
            try {   
                $expiration_date = $_POST["expiration_date"];
                $id_researcher = $_POST["id_researcher"];

                update_expiration_researcher($role_user, $id_researcher, $expiration_date);
                
                unset($_SESSION["researcher_error"]);
                header("Location: ../../pages/strict/researcher_settings.php");
                exit();
            } 
            catch (Exception $e) {

                if ($e->getMessage() == "Could not update the researcher") {
                    $_SESSION["researcher_error"] = $e->getMessage();
                }
                else {
                    $_SESSION["researcher_error"] = "Server Error";
                }

                header("Location: ../../pages/strict/researcher_settings.php");
                exit();
            }  
    }
?>