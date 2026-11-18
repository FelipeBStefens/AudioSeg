<?php
    
    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries/create_queries.php";
    require_once __DIR__ . "/../queries/view_queries.php";
    require_once __DIR__ . "/../queries/update_queries.php";
    require_once __DIR__ . "/../queries/get_all_queries.php";
    require_once __DIR__ . "/../queries/delete_queries.php";

    function get_police_stations(String $role_user){

        try {

            $connection = user_connection($role_user);
            $statement = $connection->prepare(get_all_police_stations());
            $statement->execute();
            $query = $statement->get_result();
            
            $all_police_stations = [];

            while($ps = $query->fetch_assoc()) {
                $policemen = get_policemen_from_station($ps["id_police_station"], $role_user);
                $ps["policemen"] = $policemen;
                
                array_push($all_police_stations, $ps);
            } 

            return $all_police_stations;
        }
        catch(Exception $e) {

            if ($e->getMessage() == "") {
                throw $e;
            }
            else {
                throw new Exception("Could not find all police stations!");
            }
        }
    }

    function get_policemen_from_station(int $id_station, String $role_user){
        
        try {
            $connection = user_connection($role_user);
            $statement = $connection->prepare(get_all_policemen_from_sation());
            $statement->bind_param("i", $id_station);
            $statement->execute();
            $query = $statement->get_result();
                
            $all_policemen = [];

            while($policeman = $query->fetch_assoc()) {
                array_push($all_policemen, $policeman);
            }

            return $all_policemen;
        }
        catch(Exception) {
            throw new Exception("Could not find all policemen!");
        }
    }


    function delete_station(String $role_user, int $id_station){
        
        try {
            $connection = user_connection($role_user);
            $statement = $connection->prepare(delete_police_station());
            $statement->bind_param("i", $id_station);
            $statement->execute();
        }
        catch(Exception) {
            throw new Exception("Could not delete the police stations!");
        }
    }


    function remove_policeman(String $role_user, int $id_policeman){
        
        try {
            $connection = user_connection($role_user);
            $statement = $connection->prepare(delete_policeman());
            $statement->bind_param("i", $id_policeman);
            $statement->execute();
            
        }
        catch(Exception) {
            throw new Exception("Could not delete the policeman!");
        }
    }

    
    function create_policeman(String $role_user, array $phone_list, array $user, array $policeman, int $id_police_station){
        
        $connection = user_connection($role_user);
    
        try {

            $connection->begin_transaction();

            $city = "Sapucaia Do Sul";
            $neighborhood = "Piratini";
            $street = "Av. Copacabana";

            $cep = "93216-120";
            $number_house = 100;
            $additional_information = "";

            $address_statement = $connection->prepare(create_address_default());
            $address_statement->bind_param(
                    "sss",

                    $city,
                    $neighborhood,
                    $street
                );
            $address_statement->execute();
            $id_address = $connection->insert_id;
            $address_statement->close();


            $housing_statement = $connection->prepare(create_housing());
            $housing_statement->bind_param(
                    "sssi",

                    $cep,
                    $number_house,
                    $additional_information,
                    $id_address
                );
            $housing_statement->execute();
            $id_housing = $connection->insert_id;
            $housing_statement->close();


            $phone_statement = $connection->prepare(create_phone());
            $phone_statement->bind_param(
                    "sss",

                    $phone_list["international_dialling_code"],
                    $phone_list["local_dialling_code"],
                    $phone_list["number_phone"]
                );
            $phone_statement->execute();
            $id_phone = $connection->insert_id;
            $phone_statement->close();


            $notification_statement = $connection->prepare(create_notification());
            $notification_statement->execute();
            $id_notification = $connection->insert_id;
            $notification_statement->close();

            $role_policeman = "POLICEMAN";

            $user_statement = $connection->prepare(create_role_user());
            $user_statement->bind_param(
                    "ssssssiii",

                    $user["username"],
                    $user["email"],
                    $user["password"],
                    $role_policeman,
                    $user["cpf"],
                    $user["birth_date"],
                    $id_phone,
                    $id_housing,
                    $id_notification
                );
            $user_statement->execute();
            $id_user = $connection->insert_id;
            $user_statement->close();


            $policeman_statement = $connection->prepare(insert_policeman());
            $policeman_statement->bind_param(
                    "ssssii",

                    $policeman["badge"],
                    $policeman["status"],
                    $policeman["start_period"],
                    $policeman["end_period"],
                    $id_user,
                    $id_police_station
                );
            $policeman_statement->execute();
            $policeman_statement->close();

            $connection->commit();

        }
        catch(Exception $e) {
            $connection->rollback();
            echo $e->getMessage();
            throw new Exception("Could not delete the policeman!");
        }
    }

    function create_delegate(String $role_user, array $phone_list, array $user, array $delegate, int $id_police_station){
        $connection = user_connection($role_user);
    
        try {

            $connection->begin_transaction();

            $city = "Sapucaia Do Sul";
            $neighborhood = "Piratini";
            $street = "Av. Copacabana";

            $cep = "93216-120";
            $number_house = 100;
            $additional_information = "";

            $address_statement = $connection->prepare(create_address_default());
            $address_statement->bind_param(
                    "sss",

                    $city,
                    $neighborhood,
                    $street
                );
            $address_statement->execute();
            $id_address = $connection->insert_id;
            $address_statement->close();


            $housing_statement = $connection->prepare(create_housing());
            $housing_statement->bind_param(
                    "sssi",

                    $cep,
                    $number_house,
                    $additional_information,
                    $id_address
                );
            $housing_statement->execute();
            $id_housing = $connection->insert_id;
            $housing_statement->close();


            $phone_statement = $connection->prepare(create_phone());
            $phone_statement->bind_param(
                    "sss",

                    $phone_list["international_dialling_code"],
                    $phone_list["local_dialling_code"],
                    $phone_list["number_phone"]
                );
            $phone_statement->execute();
            $id_phone = $connection->insert_id;
            $phone_statement->close();


            $notification_statement = $connection->prepare(create_notification());
            $notification_statement->execute();
            $id_notification = $connection->insert_id;
            $notification_statement->close();

            $role_delegate = "DELEGATE";

            $user_statement = $connection->prepare(create_role_user());
            $user_statement->bind_param(
                    "ssssssiii",

                    $user["username"],
                    $user["email"],
                    $user["password"],
                    $role_delegate,
                    $user["cpf"],
                    $user["birth_date"],
                    $id_phone,
                    $id_housing,
                    $id_notification
                );
            $user_statement->execute();
            $id_user = $connection->insert_id;
            $user_statement->close();


            $delegate_statement = $connection->prepare(insert_delegate());
            $delegate_statement->bind_param(
                    "ssii",

                    $delegate["start_period"],
                    $delegate["end_period"],
                    $id_user,
                    $id_police_station
                );
            $delegate_statement->execute();
            $delegate_statement->close();

            $connection->commit();   
        }
        catch(Exception $e) {
            $connection->rollback();
            echo $e->getMessage();
            throw new Exception("Could not delete the policeman!");
        }
    }
?>