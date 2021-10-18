UPDATE `per_requestservice` SET `phase`=-4 WHERE phase = 0;
ALTER TABLE `per_requestservice` CHANGE `WorkerSection` `WorkerSection` INT(11) NOT NULL;

ALTER TABLE `per_requestservice` ADD CONSTRAINT `per_requestservice_ibfk_3` FOREIGN KEY (`WorkerSection`) REFERENCES `per_sections`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `per_requestservice` ADD INDEX `WorkerSection` (`WorkerSection`);

ALTER TABLE `per_requestservice` ADD CONSTRAINT `per_requestservice_ibfk_4` FOREIGN KEY (`unitPerson_id`) REFERENCES `per_user`(`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `per_requestservice` ADD INDEX `unitPerson_id` (`unitPerson_id`);

UPDATE `per_requestservice` SET `workerPerson_id`=1 WHERE `workerPerson_id` is NUll;

UPDATE `per_requestservice` SET `workerPerson_id`=298 WHERE `workerPerson_id` = 7;

DELETE FROM `per_requestservice` WHERE `Time_Send` < "2021-05-21 11:51:27";

ALTER TABLE `per_requestservice` ADD CONSTRAINT `per_requestservice_ibfk_5` FOREIGN KEY (`workerPerson_id`) REFERENCES `per_user`(`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `per_requestservice` ADD INDEX `workerPerson_id` (`workerPerson_id`);

UPDATE `per_requestservice` SET `unitPerson_id`=`workerPerson_id`,`workerPerson_id`=16 WHERE 1;

DELETE FROM `per_data_archive` WHERE `Sensor_id` = 8 AND `AbsTime` = 26000;