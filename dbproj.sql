CREATE DATABASE IF NOT EXISTS `db`;
USE `db`;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` INT AUTO_INCREMENT,
  `pwd` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`user_id`)
);

LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES (1, '1234', 'test@test.com'), (2, 'admin', 'admin@admin.com'), (3, 'soup', 'soup');
UNLOCK TABLES;

DROP TABLE IF EXISTS `record`;
CREATE TABLE `record` (
  `rec_id` INT AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  PRIMARY KEY(`rec_id`),
  KEY `record_fk_user` (`user_id`),
  CONSTRAINT `record_fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) on delete cascade on update cascade
);

DROP TABLE IF EXISTS `todo`;
CREATE TABLE `todo` (
  `rec_id` INT,
  `timedue` DATETIME NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(256),
  PRIMARY KEY (`rec_id`),
  KEY `todo_fk_record` (`rec_id`),
  CONSTRAINT `todo_fk_record` FOREIGN KEY (`rec_id`) REFERENCES `record` (`rec_id`) on delete cascade on update cascade
);

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `rec_id` INT AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `description` varchar(256),
  `edate` DATE NOT NULL,
  `time_start` TIME NOT NULL,
  `time_end` TIME NOT NULL,
  `location` varchar(64),
  PRIMARY KEY (`rec_id`),
  KEY `event_fk_record` (`rec_id`),
  CONSTRAINT `event_fk_record` FOREIGN KEY (`rec_id`) REFERENCES `record` (`rec_id`) on delete cascade on update cascade
);

DROP TABLE IF EXISTS `habit`;
CREATE TABLE `habit` (
  `rec_id` INT AUTO_INCREMENT,
  `time_stamp` DATETIME NOT NULL,
  PRIMARY KEY (`rec_id`),
  KEY `habit_fk_record` (`rec_id`),
  CONSTRAINT `habit_fk_record` FOREIGN KEY (`rec_id`) REFERENCES `record` (`rec_id`) on delete cascade on update cascade
);

DROP TABLE IF EXISTS `sleep`;
CREATE TABLE `sleep` (
  `rec_id` INT AUTO_INCREMENT,
  `duration` INT unsigned NOT NULL,
  PRIMARY KEY (`rec_id`),
  KEY `sleep_fk_habit` (`rec_id`),
  CONSTRAINT `sleep_fk_habit` FOREIGN KEY (`rec_id`) REFERENCES `habit` (`rec_id`) on delete cascade on update cascade
);

DROP TABLE IF EXISTS `nutrition`;
CREATE TABLE `nutrition` (
  `rec_id` INT AUTO_INCREMENT,
  `protein` INT unsigned NOT NULL,
  `carb` INT unsigned NOT NULL,
  `fat` INT unsigned NOT NULL,
  PRIMARY KEY (`rec_id`),
  KEY `nutrition_fk_habit` (`rec_id`),
  CONSTRAINT `nutrition_fk_habit` FOREIGN KEY (`rec_id`) REFERENCES `habit` (`rec_id`) on delete cascade on update cascade
);


/*** Inserted Dummy Data ***/

SHOW events;
LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES (4,'christine','cgee8@gmail.com'),(5,'whitney','whittyknee@yahoo.com'),(6,'cereal','orange'), (7,'judy','judgeme@yahoo.com'), (8,'kay','k@hotmail.com');
UNLOCK TABLES;

LOCK TABLES `record` WRITE;
INSERT INTO `record` VALUES(1, 1), (2, 2),(3, 3),(4, 1),(5, 2),(6, 3),(7, 1),(8, 2),(9, 3),(10, 1),(11, 2),(12, 3),(13, 1),(14, 3),(15, 2),(16, 1),(17, 2),(18, 4),(19, 2),(20, 3),(21, 5),(22, 1),(23, 3),(24, 4),(25, 1),(26, 6),(27, 6),(28, 7), (29, 7),(30, 1);
UNLOCK TABLES;

LOCK TABLES `todo` WRITE;
INSERT INTO `todo` VALUES(1, '2017-04-20 11:59:00', 'project', 'final assignment for your favorite class!'), (2, '2017-04-21 23:59:00', 'project 2', 'Project II'), (3, '2017-04-20 8:00:00', 'morning project', 'Smile!'), (4, '2017-04-21 10:20:00', 'groceries', 'eggs'), (5, '2017-06-05 07:32:00', 'Birthday Bash Planning', 'Buy balloons');
UNLOCK TABLES;

LOCK TABLES `habit` WRITE;
INSERT INTO `habit` VALUES(6, '2017-04-21 08:32:56'), (7, '2017-04-19 23:59:00'), (8, '2017-04-21 08:32:00'),
(9, '2017-04-20 09:32:00'), (10, '2016-04-21 08:32:56'), (11, '2017-04-19 23:59:56'), (12, '2017-04-18 08:32:56'), (13, '2017-04-18 06:15:00'), (14, '2017-04-22 16:00:00'), (15, '2017-04-22 14:35:00'), (16, '2017-04-23 09:30:00'), (17, '2017-04-23 23:00:00');
UNLOCK TABLES;

LOCK TABLES `nutrition` WRITE;
INSERT INTO `nutrition` VALUES(6, 5, 5, 5), (7, 5, 10, 5), (8, 25, 20, 5), (9, 15, 25, 6), (10, 8, 10, 5), (11, 25, 25, 25);
UNLOCK TABLES;

LOCK TABLES `sleep` WRITE;
INSERT INTO `sleep` VALUES(12, 5), (13, 8), (14, 15), (15, 8), (16, 4), (17, 7);
UNLOCK TABLES;


LOCK TABLES `event`WRITE;
INSERT INTO `event` VALUES(25, 'Meeting Parents', 'The ultimate feat', '2017-04-20', '16:00:00','18:00:00', '23 Cardinal St'), (26, 'Meeting 1', 'Random', '2016-12-31', '19:00:00','20:00:00', '230 Brooksite Drive'), (27, 'Biochemistry Review', 'Prof Fertuck WFH', '2017-04-23', '11:00:00','12:30:00', 'Ell Hall'), (28, 'Movie Monday', 'Classics only', '2017-04-17', '19:00:00','23:00:00', '309 Huntington Ave'), (29, 'Female Empowerment Retreat', 'Intersectionality', '2017-04-23', '09:00:00','13:00:00', 'Harvard University'); 
UNLOCK TABLES;

LOCK TABLES `record` WRITE;
INSERT INTO `record` VALUES(31, 1), (32, 1), (33, 1), (34, 1), (35, 1), (36, 1), (37, 1), (38, 1), (39, 1), (40, 1);
UNLOCK TABLES;

LOCK TABLES `event` WRITE;
INSERT INTO `event` VALUES(31, 'CS3200', 'Professor Durant', '2017-04-17', '9:15:00','10:20:00', 'WVG'), (32, 'CS3200', 'Professor Durant', '2017-04-19', '9:15:00','10:20:00', 'WVG'),(33, 'CS3200', 'Professor Durant', '2017-04-20', '9:15:00','10:20:00', 'WVG'), (34, 'CS3800', 'Professor Gold', '2017-04-17', '14:50:00','16:30:00', 'SNE'), (35, 'CS3800', 'Professor Gold', '2017-04-19', '14:50:00','16:30:00', 'SNE'), (36, 'Biochemistry', 'Professor Fertuck', '2017-04-18', '9:50:00','15:00:00', 'Ryder'), (37, 'Biochem Lab', 'Professor Tammy', '2017-04-21', '9:50:00','11:30:00', 'Berhakis'), (38, 'MATH3081', 'Professor Lindhe', '2017-04-17', '10:30:00','11:45:00', 'Richards'), (39, 'MATH3081', 'Professor Lindhe', '2017-04-19', '10:30:00','11:45:00', 'Richards'), (40, 'MATH3081', 'Professor Lindhe', '2017-04-20', '10:30:00','11:45:00', 'Richards');
UNLOCK TABLES;

/** INSERT OF functions, procedures, events **/
/** To Turn on the Event Scheduler, you need to have this **/
SET GLOBAL event_scheduler = ON;
DROP EVENT IF EXISTS `delete_old`;

DELIMITER $$
CREATE EVENT `delete_old`	
	ON SCHEDULE EVERY 1 DAY
	ON COMPLETION PRESERVE
    COMMENT 'Clear habits everyday if older than 2 weeks'
    DO BEGIN
		DELETE FROM habit WHERE habit.time_stamp < (CURDATE() - INTERVAL 14 DAY);
    END$$
DELIMITER ;
SHOW events;

/** Added functionality for later analyses tools count_recs: Counts numberof existing records in database **/
DROP FUNCTION IF EXISTS count_recs;
DELIMITER $$
CREATE FUNCTION count_recs()
RETURNS INT
BEGIN
	DECLARE r_count INT;
	SELECT COUNT(DISTINCT(rec_id))
    INTO r_count FROM record;
    
    RETURN(r_count);
END$$
DELIMITER ;

SELECT count_recs();

/** Habit Analyses, future implementation: What is the sum of your macros **/

DROP FUNCTION IF EXISTS count_macro;
DELIMITER $$
CREATE FUNCTION count_macro(rec INT(11))
RETURNS INT(11)
BEGIN
	DECLARE answer INT(11);
	SELECT (protein + carb + fat) AS total INTO answer 
    FROM nutrition
    WHERE rec = nutrition.rec_id;
    RETURN(answer);
END$$
DELIMITER ;

SELECT count_macro(6);


/** Count the number of records the referenced user has**/
DROP PROCEDURE IF EXISTS user_recs;
DELIMITER $$
CREATE PROCEDURE user_recs(IN u INT(11))
BEGIN
	SELECT * FROM record
    WHERE u = record.user_id;
	
END$$
DELIMITER ;

Call user_recs(1);

/** Give all event tuple info**/
DROP PROCEDURE IF EXISTS event_info;
DELIMITER $$
CREATE PROCEDURE event_info(IN U INT(11))
BEGIN
	SELECT * FROM event
    WHERE u = event.rec_id;

END$$
DELIMITER ;

Call event_info(25);

/** Print the information of the given date's events **/
DROP PROCEDURE IF EXISTS date_events;
DELIMITER $$
CREATE PROCEDURE date_events(IN d DATE)
BEGIN 
	SELECT * FROM EVENT 
    WHERE d = event.edate;
END$$
DELIMITER ;

Call date_events('2017-04-23');

/** Give all habit tuple info**/
DROP PROCEDURE IF EXISTS habit_info;
DELIMITER $$
CREATE PROCEDURE habit_info(IN U INT(11))
BEGIN
	SELECT * FROM habit
    WHERE u = habit.rec_id;

END$$
DELIMITER ;

Call habit_info(6);

/** Give all todo tuple info**/
DROP PROCEDURE IF EXISTS todo_info;
DELIMITER $$
CREATE PROCEDURE todo_info(IN U INT(11))
BEGIN
	SELECT * FROM todo
    WHERE u = todo.rec_id;

END$$
DELIMITER ;

Call todo_info(4);

/** Give all sleep tuple info**/
DROP PROCEDURE IF EXISTS sleep_info;
DELIMITER $$
CREATE PROCEDURE sleep_info(IN U INT(11))
BEGIN
	SELECT * FROM sleep
    WHERE u = sleep.rec_id;

END$$
DELIMITER ;

Call sleep_info(12);

/** Give all nutrition tuple info**/
DROP PROCEDURE IF EXISTS nutrition_info;
DELIMITER $$
CREATE PROCEDURE nutrition_info(IN U INT(11))
BEGIN
	SELECT * FROM nutrition
    WHERE u = nutrition.rec_id;

END$$
DELIMITER ;

Call nutrition_info(6);