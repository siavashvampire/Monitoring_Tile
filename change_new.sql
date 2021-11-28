SET FOREIGN_KEY_CHECKS=0;

ALTER TABLE `per_product` ADD `cylinder_before` INT(11) NOT NULL AFTER `color`;
ALTER TABLE `per_product` ADD `cylinder_after` INT(11) NOT NULL AFTER `cylinder_before`;
ALTER TABLE `per_product` ADD `complementary_printing_before_digital` INT(11) NOT NULL AFTER `cylinder_after`;
ALTER TABLE `per_product` ADD `complementary_printing_before_digital_weight` INT(11) NOT NULL AFTER `complementary_printing_before_digital`;
ALTER TABLE `test`.`per_product` ADD INDEX `cylinder_after` (`cylinder_after`);
ALTER TABLE `test`.`per_product` ADD INDEX `cylinder_before` (`cylinder_before`);
ALTER TABLE `test`.`per_product` ADD INDEX `complementary_printing_before_digital` (`complementary_printing_before_digital`);
ALTER TABLE `per_product` ADD CONSTRAINT `per_product_ibfk_14` FOREIGN KEY (`cylinder_before`) REFERENCES `per_product_cylinder`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
ALTER TABLE `per_product` ADD CONSTRAINT `per_product_ibfk_15` FOREIGN KEY (`cylinder_after`) REFERENCES `per_product_cylinder`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
ALTER TABLE `per_product` ADD CONSTRAINT `per_product_ibfk_16` FOREIGN KEY (`complementary_printing_before_digital`) REFERENCES `per_product_complementary_printing_before_digital`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_product` ADD `complementary_printing_after_digital` INT(11) NOT NULL AFTER `complementary_printing_before_digital_weight`;
ALTER TABLE `test`.`per_product` ADD INDEX `complementary_printing_after_digital` (`complementary_printing_after_digital`);
ALTER TABLE `per_product` ADD CONSTRAINT `per_product_ibfk_17` FOREIGN KEY (`complementary_printing_after_digital`) REFERENCES `per_product_complementary_printing_after_digital`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `per_product` ADD `complementary_printing_after_digital_weight` INT(11) NOT NULL AFTER `complementary_printing_after_digital`;
SET FOREIGN_KEY_CHECKS=1;
