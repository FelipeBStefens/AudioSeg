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
        return connect("director", "diretor123");
    }

    function policeman_connect() {
        return connect("police", "police123");
    }

    function researcher_connect() {
        return connect("reasearcher", "reasearcher123");
    }

    function system_connect() {
        return connect("system", "system123");
    }
?>