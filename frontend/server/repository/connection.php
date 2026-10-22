<?php

    function connect(String $database_user, String $database_password) {
        
        $hostname = "localhost";
        $database_name = "audioseg_database";
        $connection = new mysqli($hostname, $database_user, $database_password, $database_name);
        
        if ($connection->connect_error) {
            die("Failed to connect with Database: " . $connection->connect_error);
        }
        
        return $connection;
    }

    function auth_connect() {
        return connect("auth", "auth123");
    }

    function delegate_connect() {
        return connect("delegate", "delegate123");
    }

    function director_connect() {
        return connect("director", "director123");
    }

    function policeman_connect() {
        return connect("policeman", "policeman123");
    }

    function researcher_connect() {
        return connect("researcher", "researcher123");
    }

    function system_connect() {
        return connect("system", "system123");
    }
?>