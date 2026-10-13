# Database
CREATE DATABASE audioseg_database;
USE audioseg_database;

# Phone Table
CREATE TABLE phone (
	
    id_phone BIGINT AUTO_INCREMENT,
    international_dialling_code INT NOT NULL DEFAULT(55),
    local_dialling_code INT NOT NULL DEFAULT(51),
    number_phone CHAR(10) NOT NULL UNIQUE,
    send BOOL DEFAULT(FALSE),
    
    CHECK (international_dialling_code > 0),
    CHECK (local_dialling_code > 0),
    CHECK (REGEXP_LIKE(number_phone, '^[0-9]{5}-[0-9]{4}$')),
    
    PRIMARY KEY (id_phone)
);

# Address Table
CREATE TABLE address (
	
    id_address BIGINT AUTO_INCREMENT,
    country VARCHAR(255) NOT NULL DEFAULT('Brazil'),
    state VARCHAR(255) NOT NULL DEFAULT('Rio Grande do Sul'),
    city VARCHAR(255) NOT NULL,
    neighborhood VARCHAR(255) NOT NULL,
    street VARCHAR(255) NOT NULL,
    
    PRIMARY KEY (id_address)
);

# Housing Table
CREATE TABLE housing (
	
    id_housing BIGINT AUTO_INCREMENT,
    cep CHAR(9) NOT NULL,
    number_house INT NOT NULL,
    additional_information VARCHAR(255) DEFAULT(''),
    id_address BIGINT NOT NULL UNIQUE,
    
    CHECK (REGEXP_LIKE(cep, '^[0-9]{5}-[0-9]{3}$')),
    CHECK (number_house > 0),
    
    PRIMARY KEY (id_housing),
    FOREIGN KEY (id_address) REFERENCES address (id_address)
);

# Localization Table
CREATE TABLE localization (

	id_localization BIGINT AUTO_INCREMENT,
    latitude DECIMAL(9, 6) NOT NULL,
    longitude DECIMAL(10, 6) NOT NULL, 
    id_address BIGINT NOT NULL UNIQUE,
    
    CHECK (latitude BETWEEN -90 AND 90),
	CHECK (longitude BETWEEN -180 AND 180),

    PRIMARY KEY (id_localization),
    FOREIGN KEY (id_address) REFERENCES address (id_address)
);

# Police Station Table
CREATE TABLE police_station (

	id_police_station BIGINT AUTO_INCREMENT,
    name_police_station VARCHAR(255) NOT NULL UNIQUE,
    id_housing BIGINT NOT NULL UNIQUE,
    
    PRIMARY KEY (id_police_station),
    FOREIGN KEY (id_housing) REFERENCES housing (id_housing)
);

# User Table
CREATE TABLE users (
	
    id_user BIGINT AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role_user VARCHAR(255) NOT NULL DEFAULT('RESEARCHER'),
    cpf CHAR(14) NOT NULL UNIQUE,
    birth_date DATE NOT NULL,
    photo VARCHAR(255) DEFAULT(NULL),
    description_user VARCHAR(255) DEFAULT(''),
    id_phone BIGINT NOT NULL UNIQUE,
    id_housing BIGINT NOT NULL UNIQUE,
    
    CHECK (REGEXP_LIKE(email, '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z0-9]{2,}$')),
    CHECK (role_user IN ('RESEARCHER', 'POLICEMAN', 'DELEGATE', 'DIRECTOR')),
    CHECK (REGEXP_LIKE(cpf, '^[0-9]{3}\\.[0-9]{3}\\.[0-9]{3}-[0-9]{2}$')),
    
    PRIMARY KEY (id_user),
    FOREIGN KEY (id_phone) REFERENCES phone (id_phone),
    FOREIGN KEY (id_housing) REFERENCES housing (id_housing)
);

# Researcher Table
CREATE TABLE researcher (
	
    id_researcher BIGINT AUTO_INCREMENT,
    institute VARCHAR(255) DEFAULT(NULL),
    expiration_date TIMESTAMP NOT NULL DEFAULT(DATE_ADD(NOW(), INTERVAL 7 DAY)),
    id_user BIGINT NOT NULL UNIQUE,
    
    PRIMARY KEY (id_researcher),
    FOREIGN KEY (id_user) REFERENCES users (id_user)
);

# Policeman Table
CREATE TABLE policeman (

	id_policeman BIGINT AUTO_INCREMENT,
    badge VARCHAR(255) NOT NULL,
    status_policeman VARCHAR(255) NOT NULL,
    start_period TIME NOT NULL DEFAULT('07:00:00'),
    end_period TIME NOT NULL DEFAULT('18:00:00'),
    id_user BIGINT NOT NULL UNIQUE,
	id_police_station BIGINT NOT NULL,
    
    CHECK (status_policeman IN ('ACTIVE', 'INACTIVE')),
    
    PRIMARY KEY (id_policeman),
    FOREIGN KEY (id_user) REFERENCES users (id_user),
    FOREIGN KEY (id_police_station) REFERENCES police_station (id_police_station)
);

# Delegate Table
CREATE TABLE delegate (

	id_delegate BIGINT AUTO_INCREMENT,
    start_period TIME NOT NULL DEFAULT('07:00:00'),
    end_period TIME NOT NULL DEFAULT('18:00:00'),
	id_user BIGINT NOT NULL UNIQUE,
    id_police_station BIGINT NOT NULL UNIQUE,
    
    PRIMARY KEY (id_delegate),
    FOREIGN KEY (id_user) REFERENCES users (id_user),
    FOREIGN KEY (id_police_station) REFERENCES police_station (id_police_station)
);

# Director Table
CREATE TABLE director (

	id_director BIGINT AUTO_INCREMENT,
    id_user BIGINT NOT NULL UNIQUE,
    
    PRIMARY KEY (id_director),
    FOREIGN KEY (id_user) REFERENCES users (id_user)
);

# Gunshot Table
CREATE TABLE gunshot (

	id_gunshot BIGINT AUTO_INCREMENT,
    date_gunshot TIMESTAMP NOT NULL,
    public_shot BOOL DEFAULT(FALSE),
    id_localization BIGINT NOT NULL UNIQUE,
    
    PRIMARY KEY (id_gunshot),
    FOREIGN KEY (id_localization) REFERENCES localization (id_localization)
);

# Sensor Table
CREATE TABLE sensor (

	id_sensor BIGINT AUTO_INCREMENT,
    name_sensor VARCHAR(255) NOT NULL DEFAULT('Sensor'),
    id_gunshot BIGINT NOT NULL,
    id_localization BIGINT NOT NULL,
    id_police_station BIGINT NOT NULL,
    
    PRIMARY KEY (id_sensor),
    FOREIGN KEY (id_gunshot) REFERENCES gunshot (id_gunshot),
    FOREIGN KEY (id_localization) REFERENCES localization (id_localization),
    FOREIGN KEY (id_police_station) REFERENCES police_station (id_police_station)
);

# Gun Table
CREATE TABLE gun (

	id_gun BIGINT AUTO_INCREMENT,
    type_gun VARCHAR(255) NOT NULL,
    accuracy DECIMAL(10, 2) NOT NULL,
    id_gunshot BIGINT NOT NULL,
    
    CHECK (accuracy >= 0),
    
    PRIMARY KEY (id_gun),
    FOREIGN KEY (id_gunshot) REFERENCES gunshot (id_gunshot)
);

# Creating Users
    
CREATE USER 'auth'@'localhost'
IDENTIFIED BY 'auth123';

CREATE USER 'researcher'@'localhost'
IDENTIFIED BY 'researcher123';

CREATE USER 'policeman'@'localhost'
IDENTIFIED BY 'policeman123';

CREATE USER 'delegate'@'localhost'
IDENTIFIED BY 'delegate123';

CREATE USER 'director'@'localhost'
IDENTIFIED BY 'director123';

CREATE USER 'system'@'localhost'
IDENTIFIED BY 'system123';

# Views to saw the gunshots

CREATE VIEW vw_public_gunshots AS
	SELECT gs.id_gunshot, gs.date_gunshot, l.latitude, l.longitude, g.id_gun, g.type_gun, g.accuracy
	FROM (gunshot AS gs INNER JOIN localization AS l ON l.id_localization = gs.id_localization)
		LEFT JOIN gun AS g ON g.id_gunshot = gs.id_gunshot
	WHERE gs.public_shot = TRUE;

CREATE VIEW vw_gunshots AS
	SELECT s.id_police_station, s.id_sensor, s.name_sensor, gs.id_gunshot, gs.date_gunshot, gs.public_shot, g.accuracy,
		l_shot.latitude AS shot_latitude, l_shot.longitude AS shot_longitude, 
        l_sensor.latitude AS sensor_latitude, l_sensor.longitude AS sensor_longitude
	FROM (((sensor AS s INNER JOIN gunshot AS gs ON gs.id_gunshot = s.id_gunshot)
		INNER JOIN localization AS l_shot ON l_shot.id_localization = gs.id_localization)
		INNER JOIN localization AS l_sensor ON l_sensor.id_localization = s.id_localization)
		LEFT JOIN gun AS g ON g.id_gunshot = gs.id_gunshot;

# Auth 

GRANT SELECT (id_user,username,email,password_hash,role_user)
ON audioseg_database.users TO 'auth'@'localhost';

# Researcher

GRANT
    INSERT (international_dialling_code,local_dialling_code,number_phone),
    UPDATE (international_dialling_code,local_dialling_code,number_phone),
    DELETE,
    SELECT (id_phone,international_dialling_code,local_dialling_code,number_phone)
ON audioseg_database.phone
TO 'researcher'@'localhost';

GRANT
    INSERT (country, state, city, neighborhood, street),
    UPDATE (country, state, city, neighborhood, street),
    DELETE,
    SELECT (id_address, country, state, city, neighborhood, street)
ON audioseg_database.address
TO 'researcher'@'localhost';

GRANT
    INSERT (cep, number_house, additional_information, id_address),
    UPDATE (cep, number_house, additional_information),
    DELETE,
    SELECT (id_housing, cep, number_house, additional_information, id_address)
ON audioseg_database.housing
TO 'researcher'@'localhost';

GRANT
    INSERT (username,email,password_hash,cpf,birth_date,photo,description_user,id_phone,id_housing),
    UPDATE (username,email,password_hash,cpf,birth_date,photo,description_user),
    DELETE,
    SELECT (id_user,username,email,cpf,birth_date,photo,description_user,id_phone,id_housing)
ON audioseg_database.users
TO 'researcher'@'localhost';

GRANT
    INSERT (institute, id_user),
    UPDATE (institute),
    DELETE,
    SELECT (id_researcher,institute,expiration_date,id_user)
ON audioseg_database.researcher
TO 'researcher'@'localhost';

GRANT SELECT
ON audioseg_database.vw_public_gunshots
TO 'researcher'@'localhost';

# Policeman

GRANT
    UPDATE (international_dialling_code,local_dialling_code,number_phone),
    SELECT (id_phone,international_dialling_code,local_dialling_code,number_phone)
ON audioseg_database.phone
TO 'policeman'@'localhost';

GRANT
    UPDATE (country,state,city,neighborhood,street),
    SELECT (id_address,country,state,city,neighborhood,street)
ON audioseg_database.address
TO 'policeman'@'localhost';

GRANT
    UPDATE (cep,number_house,additional_information),
    SELECT (id_housing,cep,number_house,additional_information,id_address)
ON audioseg_database.housing
TO 'policeman'@'localhost';

GRANT
    UPDATE (username,email,password_hash,cpf,birth_date,photo,description_user),
    SELECT (id_user,username,email,cpf,birth_date,photo,description_user,id_phone,id_housing)
ON audioseg_database.users
TO 'policeman'@'localhost';

GRANT SELECT (id_policeman,status_policeman, badge,start_period,end_period,id_user,id_police_station)
ON audioseg_database.policeman
TO 'policeman'@'localhost';

GRANT SELECT (id_police_station,name_police_station,id_housing)
ON audioseg_database.police_station
TO 'policeman'@'localhost';

GRANT SELECT
ON audioseg_database.vw_gunshots
TO 'policeman'@'localhost';

# Delegate

GRANT
    INSERT,
    UPDATE (international_dialling_code,local_dialling_code,number_phone),
    DELETE,
    SELECT (id_phone,international_dialling_code,local_dialling_code,number_phone)
ON audioseg_database.phone
TO 'delegate'@'localhost';

GRANT
    INSERT,
    UPDATE (country,state,city,neighborhood,street),
    DELETE,
    SELECT (id_address,country,state,city,neighborhood,street)
ON audioseg_database.address
TO 'delegate'@'localhost';

GRANT
    INSERT,
    UPDATE (cep,number_house,additional_information),
    DELETE,
    SELECT (id_housing,cep,number_house,additional_information,id_address)
ON audioseg_database.housing
TO 'delegate'@'localhost';

GRANT
    INSERT,
    UPDATE (username,email,password_hash,cpf,birth_date,photo,description_user),
    DELETE,
    SELECT (id_user,username,email,cpf,birth_date,photo,description_user,id_phone,id_housing)
ON audioseg_database.users
TO 'delegate'@'localhost';

GRANT
    UPDATE (expiration_date),
    DELETE,
    SELECT (id_researcher,institute,expiration_date,id_user)
ON audioseg_database.researcher
TO 'delegate'@'localhost';

GRANT
    INSERT,
    UPDATE (badge,status_policeman,start_period,end_period),
    DELETE,
    SELECT (id_policeman,status_policeman,badge,start_period,end_period,id_user,id_police_station)
ON audioseg_database.policeman
TO 'delegate'@'localhost';

GRANT SELECT (id_delegate,start_period,end_period,id_user,id_police_station)
ON audioseg_database.delegate
TO 'delegate'@'localhost';

GRANT
    UPDATE (name_police_station),
    SELECT (id_police_station,name_police_station,id_housing)
ON audioseg_database.police_station
TO 'delegate'@'localhost';

GRANT UPDATE (public_shot)
ON audioseg_database.gunshot
TO 'delegate'@'localhost';

# Director

GRANT
    INSERT,
    UPDATE (international_dialling_code,local_dialling_code,number_phone),
    DELETE,
    SELECT (id_phone,international_dialling_code,local_dialling_code,number_phone)
ON audioseg_database.phone
TO 'director'@'localhost';

GRANT
    INSERT,
    UPDATE (country,state,city,neighborhood,street),
    DELETE,
    SELECT (id_address,country,state,city,neighborhood,street)
ON audioseg_database.address
TO 'director'@'localhost';

GRANT
    INSERT,
    UPDATE (cep,number_house,additional_information),
    DELETE,
    SELECT (id_housing,cep,number_house,additional_information,id_address)
ON audioseg_database.housing
TO 'director'@'localhost';

GRANT
    INSERT,
    UPDATE (username,email,password_hash,cpf,birth_date,photo,description_user),
    DELETE,
    SELECT (id_user,username,email,cpf,birth_date,photo,description_user,id_phone,id_housing)
ON audioseg_database.users
TO 'director'@'localhost';

GRANT
    UPDATE (expiration_date),
    DELETE,
    SELECT (id_researcher,institute,expiration_date,id_user)
ON audioseg_database.researcher
TO 'director'@'localhost';

GRANT
    INSERT,
    UPDATE (badge,status_policeman,start_period,end_period),
    DELETE,
    SELECT (id_policeman,status_policeman,badge,start_period,end_period,id_user,id_police_station)
ON audioseg_database.policeman
TO 'director'@'localhost';

GRANT
    INSERT,
    UPDATE (start_period, end_period),
    DELETE,
    SELECT (id_delegate,start_period,end_period,id_user,id_police_station)
ON audioseg_database.delegate
TO 'director'@'localhost';

GRANT SELECT (id_director,id_user)
ON audioseg_database.director
TO 'director'@'localhost';

GRANT
    INSERT,
    UPDATE (name_police_station),
    DELETE,
    SELECT (id_police_station,name_police_station,id_housing)
ON audioseg_database.police_station
TO 'director'@'localhost';

GRANT UPDATE (public_shot)
ON audioseg_database.gunshot
TO 'director'@'localhost';

GRANT SELECT
ON audioseg_database.vw_gunshots
TO 'director'@'localhost';

# System 

GRANT INSERT ON audioseg_database.address
TO 'system'@'localhost';

GRANT INSERT ON audioseg_database.localization
TO 'system'@'localhost';

GRANT INSERT ON audioseg_database.gunshot
TO 'system'@'localhost';

GRANT INSERT ON audioseg_database.gun
TO 'system'@'localhost';