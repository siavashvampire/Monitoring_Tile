UPDATE `per_data`
SET `phase`=2
WHERE `phase` = 7;

UPDATE `per_data_archive`
SET `phase`=2
WHERE `phase` = 7;

UPDATE `per_data_merge`
SET `phase`=2
WHERE `phase` = 7;

UPDATE `per_data_merge_hour`
SET `phase`=2
WHERE `phase` = 7;


UPDATE `per_data_temp`
SET `phase`=2
WHERE `phase` = 7;

UPDATE `per_data`
SET `phase`=1
WHERE `phase` = 3;

UPDATE `per_data_archive`
SET `phase`=1
WHERE `phase` = 3;

UPDATE `per_data_merge`
SET `phase`=1
WHERE `phase` = 3;

UPDATE `per_data_merge_hour`
SET `phase`=1
WHERE `phase` = 3;


UPDATE `per_data_temp`
SET `phase`=1
WHERE `phase` = 3;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

-- Dumping structure for trigger test.per_execute_virtual_sensor_18
DROP TRIGGER IF EXISTS `per_execute_virtual_sensor_18`;
SET @OLDTMP_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `per_execute_virtual_sensor_18`
    AFTER INSERT
    ON `per_data_temp`
    FOR EACH ROW
BEGIN
    IF (NEW.Sensor_id = '14') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('18', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * 1), NEW.Shift_id, NEW.Shift_group_id,
                NEW.employers_id, '1', NEW.Motor_Speed, '2', '17', 'همه');

    ELSEIF (NEW.Sensor_id = '15') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('18', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * -1), NEW.Shift_id,
                NEW.Shift_group_id, NEW.employers_id, '1', NEW.Motor_Speed, '2', '17', 'همه');

    END IF;

END//
DELIMITER ;
SET SQL_MODE = @OLDTMP_SQL_MODE;

-- Dumping structure for trigger test.per_execute_virtual_sensor_19
DROP TRIGGER IF EXISTS `per_execute_virtual_sensor_19`;
SET @OLDTMP_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `per_execute_virtual_sensor_19`
    AFTER INSERT
    ON `per_data_temp`
    FOR EACH ROW
BEGIN
    IF (NEW.Sensor_id = '6') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('19', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * 1), NEW.Shift_id, NEW.Shift_group_id,
                NEW.employers_id, '1', NEW.Motor_Speed, '1', '9', 'همه');


    ELSEIF (NEW.Sensor_id = '13') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('19', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * -1), NEW.Shift_id,
                NEW.Shift_group_id, NEW.employers_id, '1', NEW.Motor_Speed, '1', '9', 'همه');

    END IF;

END//
DELIMITER ;
SET SQL_MODE = @OLDTMP_SQL_MODE;

-- Dumping structure for trigger test.per_execute_virtual_sensor_20
DROP TRIGGER IF EXISTS `per_execute_virtual_sensor_20`;
SET @OLDTMP_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `per_execute_virtual_sensor_20`
    AFTER INSERT
    ON `per_data_temp`
    FOR EACH ROW
BEGIN
    IF (NEW.Sensor_id = '2') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('20', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * 1), NEW.Shift_id, NEW.Shift_group_id,
                NEW.employers_id, '1', NEW.Motor_Speed, '2', '13', 'درجه 1');


    ELSEIF (NEW.Sensor_id = '3') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('20', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * -1), NEW.Shift_id,
                NEW.Shift_group_id, NEW.employers_id, '1', NEW.Motor_Speed, '2', '13', 'درجه 1');


    ELSEIF (NEW.Sensor_id = '4') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('20', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * -1), NEW.Shift_id,
                NEW.Shift_group_id, NEW.employers_id, '1', NEW.Motor_Speed, '2', '13', 'درجه 1');


    ELSEIF (NEW.Sensor_id = '5') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('20', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * -1), NEW.Shift_id,
                NEW.Shift_group_id, NEW.employers_id, '1', NEW.Motor_Speed, '2', '13', 'درجه 1');


    END IF;

END//
DELIMITER ;
SET SQL_MODE = @OLDTMP_SQL_MODE;

-- Dumping structure for trigger test.per_execute_virtual_sensor_21
DROP TRIGGER IF EXISTS `per_execute_virtual_sensor_21`;
SET @OLDTMP_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `per_execute_virtual_sensor_21`
    AFTER INSERT
    ON `per_data_temp`
    FOR EACH ROW
BEGIN
    IF (NEW.Sensor_id = '14') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('21', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * 1), -1, -1, -1, '1', NEW.Motor_Speed,
                '2', '17', 'همه');

    ELSEIF (NEW.Sensor_id = '15') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('21', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * -1), -1, -1, -1, '1',
                NEW.Motor_Speed, '2', '17', 'همه');

    END IF;

END//
DELIMITER ;
SET SQL_MODE = @OLDTMP_SQL_MODE;

-- Dumping structure for trigger test.per_execute_virtual_sensor_22
DROP TRIGGER IF EXISTS `per_execute_virtual_sensor_22`;
SET @OLDTMP_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `per_execute_virtual_sensor_22`
    AFTER INSERT
    ON `per_data_temp`
    FOR EACH ROW
BEGIN
    IF (NEW.Sensor_id = '6') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('22', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * 1), -1, -1, -1, '1', NEW.Motor_Speed,
                '1', '17', 'همه');

    ELSEIF (NEW.Sensor_id = '13') THEN

        INSERT INTO per_data(`Sensor_id`, `Start_time`, `JStart_time`, `AbsTime`, `counter`, `Shift_id`,
                             `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`,
                             `tileDegree`)

        VALUES ('22', NEW.Start_time, NEW.JStart_time, NEW.AbsTime, (NEW.counter * -1), -1, -1, -1, '1',
                NEW.Motor_Speed, '1', '17', 'همه');

    END IF;

END//
DELIMITER ;
SET SQL_MODE = @OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE = IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS = IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES = IFNULL(@OLD_SQL_NOTES, 1) */;
