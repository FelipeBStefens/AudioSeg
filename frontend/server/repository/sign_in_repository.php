<?php

    session_start();
    require_once __DIR__ . "/../connection.php";

    function get_user(String $email, String $password) {

        $connection = auth_connect();
        
        # Template, to make....
        $response = [
            "error" => true
        ];

        $sql_search = "SELECT * FROM users WHERE email = ?;";
        $statement = $connection->prepare($sql_search);
        $statement->bind_param("s", $email);
        
        $statement->execute();
        $query = $statement->get_result();
        
        if ($query->num_rows == 1) {

            $user = $query->fetch_assoc();

            if (password_verify($password, $user["user_password"])) {
                
                $response = [
                    "error" => false,
                    "user_id" => $user["user_id"],
                    "username" => $user["user_name"],
                    "email" => $user["user_email"],
                    "user_role" => $user["user_role"]
                ];
            
                return $response;
            }
            else {
                $response = ["error" => true];
                return $response;
            }
        }
        else {
            $response = ["error" => true];
            return $response;
        }
    }
?>