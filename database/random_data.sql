INSERT INTO phone
(id_phone, international_dialling_code, local_dialling_code, number_phone, send)
VALUES
(1, 55, 51, '99911-0001', FALSE),
(2, 55, 51, '99911-0002', FALSE),
(3, 55, 51, '99911-0003', FALSE),
(4, 55, 51, '99911-0004', FALSE),
(5, 55, 51, '99911-0005', FALSE),
(6, 55, 51, '99911-0006', FALSE),
(7, 55, 51, '99911-0007', FALSE),
(8, 55, 51, '99911-0008', FALSE),
(9, 55, 51, '99911-0009', FALSE),
(10, 55, 51, '99911-0010', FALSE);


INSERT INTO address
(id_address, country, state, city, neighborhood, street)
VALUES
(1, 'Brazil', 'Rio Grande do Sul', 'Porto Alegre', 'Centro Histórico', 'Rua dos Andradas'),
(2, 'Brazil', 'Rio Grande do Sul', 'São Leopoldo', 'Centro', 'Rua Independência'),
(3, 'Brazil', 'Rio Grande do Sul', 'Canoas', 'Centro', 'Rua Quinze de Janeiro'),


(4, 'Brazil', 'Rio Grande do Sul', 'Porto Alegre', 'Moinhos de Vento', 'Rua Padre Chagas'),
(5, 'Brazil', 'Rio Grande do Sul', 'Porto Alegre', 'Petrópolis', 'Rua Carazinho'),
(6, 'Brazil', 'Rio Grande do Sul', 'São Leopoldo', 'Cristo Rei', 'Rua Bento Gonçalves'),
(7, 'Brazil', 'Rio Grande do Sul', 'Canoas', 'Igara', 'Rua Açucena'),
(8, 'Brazil', 'Rio Grande do Sul', 'Novo Hamburgo', 'Centro', 'Rua Lima e Silva'),


(9, 'Brazil', 'Rio Grande do Sul', 'Porto Alegre', 'Partenon', 'Rua Bento Gonçalves'),
(10, 'Brazil', 'Rio Grande do Sul', 'São Leopoldo', 'Scharlau', 'Rua São Borja'),
(11, 'Brazil', 'Rio Grande do Sul', 'Canoas', 'Niterói', 'Rua Tamoio'),
(12, 'Brazil', 'Rio Grande do Sul', 'Porto Alegre', 'Menino Deus', 'Rua José de Alencar'),
(13, 'Brazil', 'Rio Grande do Sul', 'Novo Hamburgo', 'Hamburgo Velho', 'Rua General Daltro Filho');


INSERT INTO housing
(id_housing, cep, number_house, additional_information, id_address)
VALUES

(1, '90020-005', 100, 'Police station headquarters', 1),
(2, '93010-001', 200, 'Police station headquarters', 2),
(3, '92010-000', 300, 'Police station headquarters', 3),


(4, '90570-080', 101, 'Apartment 302', 4),
(5, '90460-130', 202, 'House', 5),
(6, '93020-110', 303, 'Apartment 201', 6),
(7, '92410-010', 404, 'House', 7),
(8, '93510-020', 505, 'Apartment 105', 8),


(9, '90680-001', 606, 'House', 9),
(10, '93110-100', 707, 'Apartment 401', 10),
(11, '92120-010', 808, 'House', 11),
(12, '90110-270', 909, 'Apartment 202', 12),
(13, '93510-100', 1010, 'House', 13);


INSERT INTO police_station
(id_police_station, name_police_station, id_housing)
VALUES
(1, '1st Police Station - Porto Alegre', 1),
(2, '2nd Police Station - São Leopoldo', 2),
(3, '3rd Police Station - Canoas', 3);


INSERT INTO notification
(id_notification, sound_alarms, research_updates, security_alarms)
VALUES
(1, TRUE, TRUE, TRUE),
(2, TRUE, TRUE, TRUE),
(3, FALSE, TRUE, TRUE),
(4, TRUE, FALSE, TRUE),
(5, FALSE, TRUE, TRUE),
(6, TRUE, FALSE, TRUE),
(7, TRUE, TRUE, TRUE),
(8, FALSE, FALSE, TRUE),
(9, TRUE, TRUE, TRUE),
(10, TRUE, FALSE, TRUE);


INSERT INTO users
(id_user, username, email, password_hash, role_user, cpf,
 birth_date, photo, description_user,
 id_phone, id_housing, id_notification)
VALUES


(1, 'ana.silva', 'ana.silva@example.com', 'HASH_001',
 'RESEARCHER', '123.456.789-01', '1985-03-12', NULL,
 'Senior researcher specializing in public security.',
 1, 4, 1),

(2, 'bruno.costa', 'bruno.costa@example.com', 'HASH_002',
 'RESEARCHER', '234.567.890-12', '1990-07-25', NULL,
 'Researcher focused on criminal statistics.',
 2, 5, 2),

(3, 'carla.mendes', 'carla.mendes@example.com', 'HASH_003',
 'RESEARCHER', '345.678.901-23', '1988-11-08', NULL,
 'Researcher specializing in data analysis.',
 3, 6, 3),

(4, 'diego.rocha', 'diego.rocha@example.com', 'HASH_004',
 'RESEARCHER', '456.789.012-34', '1993-01-19', NULL,
 'Researcher focused on urban security.',
 4, 7, 4),

(5, 'elisa.ferreira', 'elisa.ferreira@example.com', 'HASH_005',
 'RESEARCHER', '567.890.123-45', '1982-09-30', NULL,
 'Researcher specializing in crime prevention.',
 5, 8, 5),


(6, 'felipe.almeida', 'felipe.almeida@example.com', 'HASH_006',
 'POLICEMAN', '678.901.234-56', '1980-05-14', NULL,
 'Police officer assigned to Porto Alegre.',
 6, 9, 6),

(7, 'gabriela.santos', 'gabriela.santos@example.com', 'HASH_007',
 'POLICEMAN', '789.012.345-67', '1987-12-03', NULL,
 'Police officer assigned to São Leopoldo.',
 7, 10, 7),

(8, 'henrique.lima', 'henrique.lima@example.com', 'HASH_008',
 'POLICEMAN', '890.123.456-78', '1991-04-22', NULL,
 'Police officer assigned to Canoas.',
 8, 11, 8),

(9, 'isabela.ribeiro', 'isabela.ribeiro@example.com', 'HASH_009',
 'POLICEMAN', '901.234.567-89', '1984-08-17', NULL,
 'Police officer assigned to Porto Alegre.',
 9, 12, 9),

(10, 'joao.pereira', 'joao.pereira@example.com', 'HASH_010',
 'POLICEMAN', '012.345.678-90', '1992-06-11', NULL,
 'Police officer assigned to São Leopoldo.',
 10, 13, 10);


INSERT INTO researcher
(id_researcher, institute, expiration_date, id_user)
VALUES
(1, 'Federal University of Rio Grande do Sul (UFRGS)', DATE_ADD(NOW(), INTERVAL 7 DAY), 1),
(2, 'Pontifical Catholic University of Rio Grande do Sul (PUCRS)', DATE_ADD(NOW(), INTERVAL 7 DAY), 2),
(3, 'University of Vale do Rio dos Sinos (UNISINOS)', DATE_ADD(NOW(), INTERVAL 7 DAY), 3),
(4, 'Federal University of Health Sciences of Porto Alegre (UFCSPA)', DATE_ADD(NOW(), INTERVAL 7 DAY), 4),
(5, 'Federal Institute of Rio Grande do Sul (IFRS)', DATE_ADD(NOW(), INTERVAL 7 DAY), 5);



INSERT INTO policeman
(id_policeman, badge, status_policeman, start_period, end_period,
 id_user, id_police_station)
VALUES
(1, 'RS-1001', 'ACTIVE', '07:00:00', '19:00:00', 6, 1),
(2, 'RS-1002', 'ACTIVE', '07:00:00', '19:00:00', 7, 2),
(3, 'RS-1003', 'ACTIVE', '19:00:00', '07:00:00', 8, 3),
(4, 'RS-1004', 'ACTIVE', '07:00:00', '19:00:00', 9, 1),
(5, 'RS-1005', 'ACTIVE', '19:00:00', '07:00:00', 10, 2);


-- DROP USER 'auth'@'localhost';

-- DROP USER 'researcher'@'localhost';

-- DROP USER 'policeman'@'localhost';

-- DROP USER 'delegate'@'localhost';

-- DROP USER 'director'@'localhost';

-- DROP USER 'system'@'localhost';
