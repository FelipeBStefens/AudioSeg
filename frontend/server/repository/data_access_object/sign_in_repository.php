<?php

    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries.php";

    function get_user(String $email, String $password) {

        $connection = auth_connect();
        $statement = $connection->prepare(get_sql_auth());
        $statement->bind_param("s", $email);
        $statement->execute();
        $query = $statement->get_result();
        
        if ($query->num_rows == 1) {

            $auth = $query->fetch_assoc();

            if (password_verify($password, $auth["password_hash"])) {
                
                if ($auth["role_user"] == "RESEARCHER") {
                    return researcher_data($auth["id_user"]);
                }
                else if ($auth["role_user"] == "POLICEMAN") {
                    return policeman_data($auth["id_user"]);
                }
                else if ($auth["role_user"] == "DELEGATE") {
                    return delegate_data($auth["id_user"]);
                }
                else if ($auth["role_user"] == "DIRECTOR") {
                    return director_data($auth["id_user"]);
                }
            }
            else {
                throw new Exception("Password Invalid");
            }
        }
        else {
            throw new Exception("User Not Found");
        }
    }

    function researcher_data(int $id_user) {

        $connection = researcher_connect();
        $statement = $connection->prepare(get_sql_researcher_sign_in());
        $statement->bind_param("i", $id_user);
        $statement->execute();
        $query = $statement->get_result();

        if ($query->num_rows == 1) {

            $researcher = $query->fetch_assoc();
            return $researcher;
        }
        else {
            throw new Exception("User Not Found");
        }
    }

    function policeman_data(int $id_user) {

        $connection = policeman_connect();
        $statement = $connection->prepare(get_sql_policeman_sign_in());
        $statement->bind_param("i", $id_user);
        $statement->execute();
        $query = $statement->get_result();

        if ($query->num_rows == 1) {

            $policeman = $query->fetch_assoc();
            return $policeman;
        }
        else {
            throw new Exception("User Not Found");
        }
    }

    function delegate_data(int $id_user) {

        $connection = delegate_connect();
        $statement = $connection->prepare(get_sql_delegate_sign_in());
        $statement->bind_param("i", $id_user);
        $statement->execute();
        $query = $statement->get_result();

        if ($query->num_rows == 1) {

            $delegate = $query->fetch_assoc();
            return $delegate;
        }
        else {
            throw new Exception("User Not Found");
        }
    }

    function director_data(int $id_user) {

        $connection = director_connect();
        $statement = $connection->prepare(get_sql_director_sign_in());
        $statement->bind_param("i", $id_user);
        $statement->execute();
        $query = $statement->get_result();

        if ($query->num_rows == 1) {

            $director = $query->fetch_assoc();
            return $director;
        }
        else {
            throw new Exception("User Not Found");
        }
    }
?>