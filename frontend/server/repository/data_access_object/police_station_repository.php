<?php
    require_once __DIR__ . "/../connection.php";
    require_once __DIR__ . "/../queries/create_queries.php";
    require_once __DIR__ . "/../queries/view_queries.php";
    require_once __DIR__ . "/../queries/update_queries.php";
    require_once __DIR__ . "/../queries/get_all_queries.php";
    require_once __DIR__ . "/../queries/delete_queries.php";

    
    function get_police_stations(String $role_user, int $id_police_station){

        try {
            $connection = user_connection($role_user);
            $statement = $connection->prepare(get_all_police_stations());
            $statement->execute();
            $query = $statement->get_result();
            
            $all_police_stations = [];

            while($ps = $query->fetch_assoc()) {

                if ($role_user == "DIRECTOR") {
                    
                    $policemen = get_policemen_from_station($ps["id_police_station"], $role_user);
                    $ps["policemen"] = $policemen;
                    array_push($all_police_stations, $ps);                    
                }
                else if ($role_user == "POLICEMAN" || $role_user == "DELEGATE") {
                    
                    if ($ps["id_police_station"] == $id_police_station) {
                        $policemen = get_policemen_from_station($ps["id_police_station"], $role_user);
                        $ps["policemen"] = $policemen;
                        array_push($all_police_stations, $ps);  

                        break;
                    }
                }
            } 

            return $all_police_stations;
        }
        catch(Exception $e) {
            echo $e->getMessage();
            throw $e;
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
        catch(Exception $e) {
            $e->getMessage();
            throw new Exception("Could not find all policemen!");
        }
    }


    function delete_station(String $role_user, int $id_station, int $id_address, array $list_policemen) {

        $connection = user_connection($role_user);
        $list_delegates = get_delegates_from_station($id_station, $role_user);

        foreach (array_merge($list_policemen, $list_delegates) as $officer) {
            $list_id = [
                "id_user" => $officer["id_user"],
                "id_address" => $officer["id_address"],
                "id_phone" => $officer["id_phone"],
                "id_notification" => $officer["id_notification"]
            ];

            remove_policeman($role_user, $list_id);
        }

        try {
            $connection->begin_transaction();

            $statement_sensor = $connection->prepare(delete_station_sensors());
            $statement_sensor->bind_param("i", $id_station);
            $statement_sensor->execute();
            $statement_sensor->close();

            $statement_station = $connection->prepare(delete_police_station());
            $statement_station->bind_param("i", $id_station);
            $statement_station->execute();
            $statement_station->close();

            $statement_address = $connection->prepare(delete_address());
            $statement_address->bind_param("i", $id_address);
            $statement_address->execute();
            $statement_address->close();

            $connection->commit();
        } 
        catch (Exception $e) {
            $connection->rollback();
            echo $e->getMessage();
            throw new Exception("Could not delete the police station!");
        }
    }

    function get_delegates_from_station(int $id_station, String $role_user): array {
        $connection = user_connection($role_user);

        $statement = $connection->prepare(get_station_delegates());
        $statement->bind_param("i", $id_station);
        $statement->execute();
        $result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        $statement->close();

        return $result;
    }

    function remove_policeman(String $role_user, array $list_id){

        $connection = user_connection($role_user);

        try {
            $connection->begin_transaction();

            $statement_address = $connection->prepare(delete_address());
            $statement_address->bind_param("i", $list_id["id_address"]);
            $statement_address->execute();
            $statement_address->close();

            $statement_phone = $connection->prepare(delete_phone());
            $statement_phone->bind_param("i", $list_id["id_phone"]);
            $statement_phone->execute();
            $statement_phone->close();

            $statement_notification = $connection->prepare(delete_notification());
            $statement_notification->bind_param("i", $list_id["id_notification"]);
            $statement_notification->execute();
            $statement_notification->close();

            $statement_user = $connection->prepare(delete_user());
            $statement_user->bind_param("i", $list_id["id_user"]);
            $statement_user->execute();
            $statement_user->close();
            
            $connection->commit();
        }
        catch(Exception) {
            $connection->rollback();
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
            $role_policeman = "POLICEMAN";
            $cep = "93216-120";
            $number_house = 100;
            $additional_information = "";

            $address_statement = $connection->prepare(create_address_default());
            $address_statement->bind_param("sss", $city, $neighborhood, $street);
            $address_statement->execute();
            $id_address = $connection->insert_id;
            $address_statement->close();

            $housing_statement = $connection->prepare(create_housing());
            $housing_statement->bind_param("sssi", $cep, $number_house, $additional_information, $id_address);
            $housing_statement->execute();
            $id_housing = $connection->insert_id;
            $housing_statement->close();

            $phone_statement = $connection->prepare(create_phone());
            $phone_statement->bind_param("sss", $phone_list["international_dialling_code"], $phone_list["local_dialling_code"], $phone_list["number_phone"]);
            $phone_statement->execute();
            $id_phone = $connection->insert_id;
            $phone_statement->close();

            $notification_statement = $connection->prepare(create_notification());
            $notification_statement->execute();
            $id_notification = $connection->insert_id;
            $notification_statement->close();

            $user_statement = $connection->prepare(create_role_user());
            $user_statement->bind_param("ssssssiii", $user["username"], $user["email"], $user["password"], $role_policeman, $user["cpf"], $user["birth_date"], $id_phone, $id_housing, $id_notification);
            $user_statement->execute();
            $id_user = $connection->insert_id;
            $user_statement->close();

            $policeman_statement = $connection->prepare(insert_policeman());
            $policeman_statement->bind_param("ssssii", $policeman["badge"], $policeman["status"], $policeman["start_period"], $policeman["end_period"], $id_user, $id_police_station);
            $policeman_statement->execute();
            $policeman_statement->close();

            $connection->commit();
        }
        catch(Exception $e) {
            $connection->rollback();
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
            $role_delegate = "DELEGATE";
            $cep = "93216-120";
            $number_house = 100;
            $additional_information = "";

            $address_statement = $connection->prepare(create_address_default());
            $address_statement->bind_param("sss", $city, $neighborhood, $street);
            $address_statement->execute();
            $id_address = $connection->insert_id;
            $address_statement->close();

            $housing_statement = $connection->prepare(create_housing());
            $housing_statement->bind_param("sssi", $cep, $number_house, $additional_information, $id_address);
            $housing_statement->execute();
            $id_housing = $connection->insert_id;
            $housing_statement->close();

            $phone_statement = $connection->prepare(create_phone());
            $phone_statement->bind_param("sss", $phone_list["international_dialling_code"], $phone_list["local_dialling_code"], $phone_list["number_phone"]);
            $phone_statement->execute();
            $id_phone = $connection->insert_id;
            $phone_statement->close();

            $notification_statement = $connection->prepare(create_notification());
            $notification_statement->execute();
            $id_notification = $connection->insert_id;
            $notification_statement->close();

            $user_statement = $connection->prepare(create_role_user());
            $user_statement->bind_param("ssssssiii", $user["username"], $user["email"], $user["password"], $role_delegate, $user["cpf"], $user["birth_date"], $id_phone, $id_housing, $id_notification);
            $user_statement->execute();
            $id_user = $connection->insert_id;
            $user_statement->close();

            $delegate_statement = $connection->prepare(insert_delegate());
            $delegate_statement->bind_param("ssii", $delegate["start_period"], $delegate["end_period"], $id_user, $id_police_station);
            $delegate_statement->execute();
            $delegate_statement->close();

            $connection->commit();   
        }
        catch(Exception $e) {
            $connection->rollback();
            throw new Exception("Could not delete the policeman!");
        }
    }


    function create_police_station(String $role_user, $station){

        $connection = user_connection($role_user);

        try{
            $connection->begin_transaction();

            $address_statement = $connection->prepare(create_address());
            $address_statement->bind_param("sssss",
                $station["country"], 
                $station["state"], 
                $station["city"],
                $station["neighborhood"],
                $station["street"]
            );
            $address_statement->execute();
            $id_address = $connection->insert_id;
            $address_statement->close();

            $housing_statement = $connection->prepare(create_housing());
            $housing_statement->bind_param("sssi",
                $station["cep"],
                $station["number_house"], 
                $station["additional_information"], 
                $id_address
            );
            $housing_statement->execute();
            $id_housing = $connection->insert_id;
            $housing_statement->close();

            $station_statement = $connection->prepare(create_station());
            $station_statement->bind_param("si", $station["name"], $id_housing);
            $station_statement->execute();
            $station_statement->close();

            $connection->commit();
        }
        catch(Exception $e){
            $connection->rollback();
            throw new Exception("Could not create the police station!");
        }
    }
?>