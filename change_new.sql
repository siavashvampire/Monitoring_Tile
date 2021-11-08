ALTER TABLE `per_product_kind` ADD `thickness` INT(11) NOT NULL DEFAULT '0' AFTER `tile_length`;
ALTER TABLE `per_product_kind` CHANGE `tile_width` `width` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `per_product_kind` CHANGE `tile_length` `length` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE per_product_kind RENAME per_product_size;