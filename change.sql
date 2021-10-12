SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE per_sensor_name RENAME per_sensors;
ALTER TABLE `per_sensors` CHANGE `Sensor_name` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL;
ALTER TABLE `per_sensors` CHANGE `Sensor_id` `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `per_sections` CHANGE `sectionId` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `per_sections` CHANGE `Name` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `per_tile_kind` CHANGE `tile_id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `per_tile_kind` CHANGE `tile_name` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL;

ALTER TABLE `per_units` CHANGE `Name` `label` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL;
ALTER TABLE `per_units` CHANGE `unitId` `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `per_data` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_data_archive` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_data_merge` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_data_merge_hour` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_data_temp` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;

UPDATE `per_data` SET `phase`=1 WHERE `phase`=3;
UPDATE `per_data` SET `phase`=2 WHERE `phase`=7;
UPDATE `per_data` SET `phase`=3 WHERE `phase` = 'سایر';
ALTER TABLE `per_data` CHANGE `phase` `phase` INT(11) NOT NULL;

UPDATE `per_data_archive` SET `phase`=1 WHERE `phase`=3;
UPDATE `per_data_archive` SET `phase`=2 WHERE `phase`=7;
UPDATE `per_data_archive` SET `phase`=3 WHERE `phase` = 'سایر';
ALTER TABLE `per_data_archive` CHANGE `phase` `phase` INT(11) NOT NULL;

UPDATE `per_data_merge` SET `phase`=1 WHERE `phase`=3;
UPDATE `per_data_merge` SET `phase`=2 WHERE `phase`=7;
UPDATE `per_data_merge` SET `phase`=3 WHERE `phase` = 'سایر';
ALTER TABLE `per_data_merge` CHANGE `phase` `phase` INT(11) NOT NULL;

UPDATE `per_data_merge_hour` SET `phase`=1 WHERE `phase`=3;
UPDATE `per_data_merge_hour` SET `phase`=2 WHERE `phase`=7;
UPDATE `per_data_merge_hour` SET `phase`=3 WHERE `phase` = 'سایر';
ALTER TABLE `per_data_merge_hour` CHANGE `phase` `phase` INT(11) NOT NULL;

UPDATE `per_data_temp` SET `phase`=1 WHERE `phase`=3;
UPDATE `per_data_temp` SET `phase`=2 WHERE `phase`=7;
UPDATE `per_data_temp` SET `phase`=3 WHERE `phase` = 'سایر';
ALTER TABLE `per_data_temp` CHANGE `phase` `phase` INT(11) NOT NULL;

ALTER TABLE `per_data` ADD INDEX `phase` (`phase`);
ALTER TABLE `per_data` ADD CONSTRAINT `per_data_ibfk_6` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `per_data_archive` ADD INDEX `phase` (`phase`);
ALTER TABLE `per_data_archive` ADD CONSTRAINT `per_data_archive_ibfk_6` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `per_data_merge` ADD INDEX `phase` (`phase`);
ALTER TABLE `per_data_merge` ADD CONSTRAINT `per_data_merge_ibfk_6` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `per_data_merge_hour` ADD INDEX `phase` (`phase`);
ALTER TABLE `per_data_merge_hour` ADD CONSTRAINT `per_data_merge_hour_ibfk_6` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `per_data_temp` ADD INDEX `phase` (`phase`);
ALTER TABLE `per_data_temp` ADD CONSTRAINT `per_data_temp_ibfk_6` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE per_sensoractivelog RENAME per_sensor_active_log;
ALTER TABLE per_sensoractivelogarchive RENAME per_sensor_active_log_archive;
ALTER TABLE per_sensoractivelogmerge RENAME per_sensor_active_log_merge;

ALTER TABLE per_switchactivelog RENAME per_switch_active_log;
ALTER TABLE per_switchactivelogarchive RENAME per_switch_active_log_archive;

ALTER TABLE `per_sensor_active_log` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_sensor_active_log` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;
ALTER TABLE `per_sensor_active_log` CHANGE `phase` `phase` INT(11) NOT NULL;
ALTER TABLE `per_sensor_active_log` ADD CONSTRAINT `per_sensor_active_log_ibfk_9` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log` ADD INDEX `phase` (`phase`);

ALTER TABLE `per_sensor_active_log_archive` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_sensor_active_log_archive` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;
ALTER TABLE `per_sensor_active_log_archive` CHANGE `phase` `phase` INT(11) NOT NULL;

ALTER TABLE `per_sensor_active_log_archive` ADD CONSTRAINT `per_sensor_active_log_archive_ibfk_3` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log_archive` ADD INDEX `phase` (`phase`);

ALTER TABLE `per_sensor_active_log_merge` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_sensor_active_log_merge` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;
ALTER TABLE `per_sensor_active_log_merge` CHANGE `phase` `phase` INT(11) NOT NULL;
ALTER TABLE `per_sensor_active_log_merge` ADD CONSTRAINT `per_sensoractivelogMerge_ibfk_9` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log_merge` ADD INDEX `phase` (`phase`);

ALTER TABLE `per_switch_active_log` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_switch_active_log` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;
ALTER TABLE `per_switch_active_log` CHANGE `phase` `phase` INT(11) NOT NULL;
ALTER TABLE `per_switch_active_log` ADD CONSTRAINT `per_switch_active_log_ibfk_9` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `per_switch_active_log` ADD INDEX `phase` (`phase`);

ALTER TABLE `per_switch_active_log_archive` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_switch_active_log_archive` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;
ALTER TABLE `per_switch_active_log_archive` CHANGE `phase` `phase` INT(11) NOT NULL;
ALTER TABLE `per_switch_active_log_archive` ADD CONSTRAINT `per_switch_active_log_archive_ibfk_3` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_switch_active_log_archive` ADD INDEX `phase` (`phase`);

ALTER TABLE `per_data` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;
ALTER TABLE `per_data_archive` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;
ALTER TABLE `per_data_merge` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;
ALTER TABLE `per_data_merge_hour` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;
ALTER TABLE `per_data_temp` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;

ALTER TABLE `per_sensors` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_sensors` DROP INDEX `unitId`, ADD INDEX `unit` (`unit`) USING BTREE;
ALTER TABLE `per_sensors` CHANGE `phase` `phase` INT(11) NOT NULL;
ALTER TABLE `per_sensors` ADD CONSTRAINT `per_sensors_ibfk_3` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensors` ADD INDEX `phase` (`phase`);

ALTER TABLE `per_camswitch` CHANGE `Switch_id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `per_camswitch` CHANGE `Switch_name` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL;
ALTER TABLE `per_camswitch` CHANGE `unitId` `unit` INT(11) NULL DEFAULT NULL;
ALTER TABLE `per_camswitch` ADD CONSTRAINT `per_camswitch_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `per_units`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_camswitch` CHANGE `phase` `phase` INT(11) NOT NULL;
ALTER TABLE `per_camswitch` ADD CONSTRAINT `per_camswitch_ibfk_2` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `per_requestservice_buginfluence` CHANGE `Title` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `per_requestservice_cost` CHANGE `Title` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `per_requestservice_donework` CHANGE `Title` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `per_requestservice_failure` CHANGE `Title` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `per_requestservice_latency` CHANGE `Title` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `per_requestservice_system_status` CHANGE `Title` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `per_requestservice_worktitle` CHANGE `Title` `label` VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `per_requestservice` ADD CONSTRAINT `per_requestservice_ibfk_1` FOREIGN KEY (`phase`) REFERENCES `per_phases`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_requestservice` ADD INDEX `phase` (`phase`);
ALTER TABLE `per_requestservice` ADD CONSTRAINT `per_requestservice_ibfk_2` FOREIGN KEY (`section`) REFERENCES `per_sections`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_requestservice` ADD INDEX `section` (`section`);

DROP TRIGGER `per_sensoractivelogarchive_after_insert`;
DROP TRIGGER `per_sensoractivelogarchive_after_update`;
DELIMITER //
CREATE TRIGGER `per_sensor_active_log_archive_after_insert` AFTER INSERT ON `per_sensor_active_log_archive` FOR EACH ROW BEGIN

	INSERT INTO per_sensor_active_log(`ActivityId` , `Sensor_id`,`Start_time`,`JStart_time`,`End_Time`,`JEnd_Time`,`Start_shift_id`,`Start_Shift_group_id`,`Start_employers_id`,`Start_Tile_Kind`,`End_Shift_id`,`End_Shift_group_id`,`End_employers_id`,`End_Tile_Kind`,`phase`,`unit`,`tileDegree`)



   VALUES(NEW.ActivityId,NEW.Sensor_id,NEW.Start_time,NEW.JStart_time,NEW.End_Time,NEW.JEnd_Time,NEW.Start_shift_id ,NEW.Start_Shift_group_id,NEW.Start_employers_id ,NEW.Start_Tile_Kind ,NEW.End_Shift_id  ,NEW.End_Shift_group_id,NEW.End_employers_id,NEW.End_Tile_Kind ,NEW.phase,NEW.unit,NEW.tileDegree);

	INSERT INTO per_sensor_active_log_merge(`ActivityId` , `Sensor_id`,`Start_time`,`JStart_time`,`End_Time`,`JEnd_Time`,`Start_shift_id`,`Start_Shift_group_id`,`Start_employers_id`,`Start_Tile_Kind`,`End_Shift_id`,`End_Shift_group_id`,`End_employers_id`,`End_Tile_Kind`,`phase`,`unit`,`tileDegree`)
 VALUES(NEW.ActivityId,NEW.Sensor_id,NEW.Start_time,NEW.JStart_time,NEW.End_Time,NEW.JEnd_Time,NEW.Start_shift_id ,NEW.Start_Shift_group_id,NEW.Start_employers_id ,NEW.Start_Tile_Kind ,NEW.End_Shift_id  ,NEW.End_Shift_group_id,NEW.End_employers_id,NEW.End_Tile_Kind ,NEW.phase,NEW.unit,NEW.tileDegree);

END//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `per_sensor_active_log_archive_after_update` BEFORE UPDATE ON `per_sensor_active_log_archive` FOR EACH ROW BEGIN

	UPDATE per_sensor_active_log SET `ActivityId`=NEW.ActivityId,`Sensor_id`=NEW.Sensor_id,`Start_time`=NEW.Start_time,`JStart_time`=NEW.JStart_time,

	`End_Time`=NEW.End_Time,`JEnd_Time`=NEW.JEnd_Time,`Start_shift_id`=NEW.Start_shift_id,`Start_Shift_group_id`=NEW.Start_Shift_group_id,

	`Start_employers_id`=NEW.Start_employers_id,`Start_Tile_Kind`=NEW.Start_Tile_Kind,`End_Shift_id`=NEW.End_Shift_id,

	`End_Shift_group_id`=NEW.End_Shift_group_id,`End_employers_id`=NEW.End_employers_id,`End_Tile_Kind`=NEW.End_Tile_Kind,

	`phase`=NEW.phase,`unit`=NEW.unit,`tileDegree`=NEW.tileDegree

	 WHERE `ActivityId`=NEW.ActivityId;

	 UPDATE per_sensor_active_log_merge SET `ActivityId`=NEW.ActivityId,`Sensor_id`=NEW.Sensor_id,`Start_time`=NEW.Start_time,`JStart_time`=NEW.JStart_time,

	`End_Time`=NEW.End_Time,`JEnd_Time`=NEW.JEnd_Time, `DiffTimeSec` = IF(NEW.End_Time is not null , TIMESTAMPDIFF(SECOND,NEW.Start_time, NEW.End_Time) , TIMESTAMPDIFF(SECOND, NEW.Start_time , now()) ) , `Start_shift_id`=NEW.Start_shift_id,`Start_Shift_group_id`=NEW.Start_Shift_group_id,

	`Start_employers_id`=NEW.Start_employers_id,`Start_Tile_Kind`=NEW.Start_Tile_Kind,`End_Shift_id`=NEW.End_Shift_id,

	`End_Shift_group_id`=NEW.End_Shift_group_id,`End_employers_id`=NEW.End_employers_id,`End_Tile_Kind`=NEW.End_Tile_Kind,

	`phase`=NEW.phase,`unit`=NEW.unit,`tileDegree`=NEW.tileDegree

	 WHERE `ActivityId`=NEW.ActivityId;

END//
DELIMITER ;
SET FOREIGN_KEY_CHECKS=1;

UPDATE `per_field` SET `type` = 'fieldCall_Sections_sections' WHERE `per_field`.`fieldId` = 15;
UPDATE `per_field` SET `type`='fieldCall_units_units' WHERE `type`='fieldCall_siavash_units';
UPDATE `per_field` SET `type`='fieldCall_LineMonitoring_phase' WHERE `type`='fieldCall_siavash_phase'

INSERT INTO `per_phases` (`id`, `label`) VALUES ('-4', 'همه');
INSERT IGNORE INTO `per_units` (`id`, `label`) VALUES
    (-4, 'همه'),
    (-3, 'مدیران'),
    (-1, 'پشتیبانی فنی'),
    (-2, 'پشتیبانی IT');

UPDATE `per_camswitch` SET `phase` = '2' WHERE `per_camswitch`.`id` = 1;
UPDATE `per_switch_active_log_archive` SET `phase`=2;
UPDATE `per_switch_active_log` SET `phase`=2;