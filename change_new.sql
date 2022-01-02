ALTER TABLE `per_product_routine` ADD `oblique_bool` TINYINT NOT NULL DEFAULT '1' AFTER `oblique`;
ALTER TABLE `per_product_routine` ADD `straight_bool` TINYINT NOT NULL DEFAULT '1' AFTER `straight`;


ALTER TABLE `per_product_routine` ADD `insert_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `product`;
UPDATE `per_product_routine` SET `insert_date` = routine_date WHERE 1;
ALTER TABLE `per_product_routine` CHANGE `routine_date` `routine_date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP;

UPDATE `per_product_routine` SET oblique_bool = 0,straight_bool=0 WHERE id = 5;
UPDATE `per_product_routine` SET oblique_bool = 0 WHERE id = 40;


ALTER TABLE `per_product_qc` ADD `insert_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `product`;
UPDATE `per_product_qc` SET `insert_date` = qc_date WHERE 1;
ALTER TABLE `per_product_qc` CHANGE `qc_date` `qc_date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP;

