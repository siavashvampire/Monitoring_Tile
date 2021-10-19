ALTER TABLE `per_sensor_active_log_merge`
    DROP FOREIGN KEY `per_sensoractivelogMerge_ibfk_1`;
ALTER TABLE `per_sensor_active_log_merge`
    ADD CONSTRAINT `per_sensor_active_log_merge_ibfk_1` FOREIGN KEY (`Start_employers_id`) REFERENCES `per_user` (`userId`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log_merge`
    DROP FOREIGN KEY `per_sensoractivelogMerge_ibfk_2`;
ALTER TABLE `per_sensor_active_log_merge`
    ADD CONSTRAINT `per_sensor_active_log_merge_ibfk_2` FOREIGN KEY (`Sensor_id`) REFERENCES `per_sensors` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log_merge`
    DROP FOREIGN KEY `per_sensoractivelogMerge_ibfk_3`;
ALTER TABLE `per_sensor_active_log_merge`
    ADD CONSTRAINT `per_sensor_active_log_merge_ibfk_3` FOREIGN KEY (`Start_Tile_Kind`) REFERENCES `per_tile_kind` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log_merge`
    DROP FOREIGN KEY `per_sensoractivelogMerge_ibfk_4`;
ALTER TABLE `per_sensor_active_log_merge`
    ADD CONSTRAINT `per_sensor_active_log_merge_ibfk_4` FOREIGN KEY (`Start_shift_id`) REFERENCES `per_shift_work` (`shift_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log_merge`
    DROP FOREIGN KEY `per_sensoractivelogMerge_ibfk_5`;
ALTER TABLE `per_sensor_active_log_merge`
    ADD CONSTRAINT `per_sensor_active_log_merge_ibfk_5` FOREIGN KEY (`End_employers_id`) REFERENCES `per_user` (`userId`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log_merge`
    DROP FOREIGN KEY `per_sensoractivelogMerge_ibfk_6`;
ALTER TABLE `per_sensor_active_log_merge`
    ADD CONSTRAINT `per_sensor_active_log_merge_ibfk_6` FOREIGN KEY (`End_Tile_Kind`) REFERENCES `per_tile_kind` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log_merge`
    DROP FOREIGN KEY `per_sensoractivelogMerge_ibfk_7`;
ALTER TABLE `per_sensor_active_log_merge`
    ADD CONSTRAINT `per_sensor_active_log_merge_ibfk_7` FOREIGN KEY (`End_Shift_id`) REFERENCES `per_shift_work` (`shift_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log_merge`
    DROP FOREIGN KEY `per_sensoractivelogMerge_ibfk_8`;
ALTER TABLE `per_sensor_active_log_merge`
    ADD CONSTRAINT `per_sensor_active_log_merge_ibfk_8` FOREIGN KEY (`unit`) REFERENCES `per_units` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_sensor_active_log_merge`
    DROP FOREIGN KEY `per_sensoractivelogMerge_ibfk_9`;
ALTER TABLE `per_sensor_active_log_merge`
    ADD CONSTRAINT `per_sensor_active_log_merge_ibfk_9` FOREIGN KEY (`phase`) REFERENCES `per_phases` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;