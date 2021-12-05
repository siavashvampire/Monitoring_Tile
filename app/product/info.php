<?php
return [
    'info' => [
        'name' => 'product',
        'description' => 'product',
        'version' => '1.0.0.0',
        'author' => 'Siavash Sepahi',
        'support' => '09379206248',
    ],
    'configuration' => [
    ],
    'db' => [
        'product_size' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'width' => "INT(11) NOT NULL DEFAULT '0'",
                'length' => "INT(11) NOT NULL DEFAULT '0'",
                'thickness' => "INT(11) NOT NULL DEFAULT '0'",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_glaze' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'parent' => 'INT(11) DEFAULT NULL ',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
                'parent'
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'parent' => ['table' => 'product_glaze', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'product_punch' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_cylinder' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_complementary_printing_before_digital' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_complementary_printing_after_digital' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_color' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_digitalPrint_color' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_brand' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'agent' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_kind' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_technique' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_effect' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_decor' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_degree' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_engobe' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_body' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_template' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'bumper_glue' => "INT(11) NOT NULL",
                'selfon' => "INT(11) NOT NULL",
                'weight_after_chamfer' => "INT(11) NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_glue' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_plastic' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_strap' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'carton_theme' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [

            ]
        ],
        'carton_size' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'width' => "INT(11) NOT NULL DEFAULT '0'",
                'length' => "INT(11) NOT NULL DEFAULT '0'",
                'thickness' => "INT(11) NOT NULL DEFAULT '0'",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'pallet_size' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'width' => "INT(11) NOT NULL DEFAULT '0'",
                'length' => "INT(11) NOT NULL DEFAULT '0'",
                'thickness' => "INT(11) NOT NULL DEFAULT '0'",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'product_pallet' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'pallet_size' => "INT(11) NOT NULL",
                'pallet_weight' => "INT(11) NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'pallet_size' => ['table' => 'pallet_size', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'product_carton' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'carton_weight' => "INT(11) NOT NULL",
                'carton_theme' => "INT(11) NOT NULL",
                'carton_size' => "INT(11) NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'carton_theme' => ['table' => 'product_carton_theme', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton_size' => ['table' => 'product_carton_size', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'product_carton_packing' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'carton' => "INT(11) NOT NULL",
                'glue' => "INT(11) NOT NULL",
                'number_of_tiles' => "INT(11) NOT NULL",
                'plastic' => "INT(11) NOT NULL",
                'strap' => "INT(11) NOT NULL",
                'plastic_weight' => "INT(11) NOT NULL",
                'strap_weight' => "INT(11) NOT NULL",
                'glue_weight' => "INT(11) NOT NULL",
            ],
            'KEY' => [
                'carton',
                'glue',
                'strap',
                'plastic',
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'carton' => ['table' => 'product_carton', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'glue' => ['table' => 'product_glue', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'strap' => ['table' => 'product_strap', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'plastic' => ['table' => 'product_plastic', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],

            ]
        ],
        'product_pallet_packing' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'pallet' => "INT(11) NOT NULL",
                'carton_on_pallet' => "INT(11) NOT NULL",
                'plastic' => "INT(11) NOT NULL",
                'strap' => "INT(11) NOT NULL",
                'plastic_weight' => "INT(11) NOT NULL",
                'strap_weight' => "INT(11) NOT NULL",
                'carton' => "INT(11) NOT NULL",
            ],
            'KEY' => [
                'pallet',
                'carton',
                'strap',
                'plastic',
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'pallet' => ['table' => 'product_pallet', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton' => ['table' => 'product_carton', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'strap' => ['table' => 'product_strap', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'plastic' => ['table' => 'product_plastic', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],

            ]
        ],
        'product_packing' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'carton_packing_carton' => "INT(11) NOT NULL",
                'carton_packing_carton_size' => "INT(11) NOT NULL",
                'carton_packing_carton_theme' => "INT(11) NOT NULL",
                'carton_packing_carton_weight' => "INT(11) NOT NULL",
                'carton_packing_glue' => "INT(11) NOT NULL",
                'carton_packing_strap' => "INT(11) NOT NULL",
                'carton_packing_strap_weight' => "INT(11) NOT NULL",
                'carton_packing_glue_amount' => "INT(11) NOT NULL",
                'carton_packing_plastic' => "INT(11) NOT NULL",
                'carton_packing_plastic_weight' => "INT(11) NOT NULL",
                'carton_packing_number_of_tiles' => "INT(11) NOT NULL",
                'pallet_packing_pallet' => "INT(11) NOT NULL",
                'pallet_packing_pallet_size' => "INT(11) NOT NULL",
                'pallet_packing_pallet_weight' => "INT(11) NOT NULL",
                'pallet_packing_strap' => "INT(11) NOT NULL",
                'pallet_packing_strap_weight' => "INT(11) NOT NULL",
                'pallet_packing_plastic' => "INT(11) NOT NULL",
                'pallet_packing_plastic_weight' => "INT(11) NOT NULL",
                'pallet_packing_carton_on_pallet' => "INT(11) NOT NULL",
                'pallet_packing_carton' => "INT(11) NOT NULL",
            ],
            'KEY' => [
                'carton_packing_carton',
                'carton_packing_carton_size',
                'carton_packing_carton_theme',
                'carton_packing_glue',
                'carton_packing_strap',
                'carton_packing_plastic',
                'pallet_packing_pallet',
                'pallet_packing_pallet_size',
                'pallet_packing_strap',
                'pallet_packing_plastic',
                'pallet_packing_carton',
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'carton_packing_carton' => ['table' => 'product_carton', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton_packing_carton_size' => ['table' => 'carton_size', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton_packing_carton_theme' => ['table' => 'carton_theme', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton_packing_glue' => ['table' => 'product_glue', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton_packing_strap' => ['table' => 'product_strap', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton_packing_plastic' => ['table' => 'product_plastic', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'pallet_packing_pallet' => ['table' => 'product_pallet', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'pallet_packing_pallet_size' => ['table' => 'pallet_size', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'pallet_packing_strap' => ['table' => 'product_strap', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'pallet_packing_plastic' => ['table' => 'product_plastic', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'pallet_packing_carton' => ['table' => 'product_carton', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'product' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'example_code' => "INT(11) NOT NULL",
                'production_design_code' => "varchar(65) NOT NULL",
                'kind' => "INT(11) NOT NULL",
                'size' => "INT(11) NOT NULL",
                'phase' => "INT(11) NOT NULL",
                'color' => "INT(11) NOT NULL",
                'cylinder_before' => "INT(11) NOT NULL",
                'cylinder_after' => "INT(11) NOT NULL",
                'complementary_printing_before_digital' => "INT(11) NOT NULL",
                'complementary_printing_before_digital_weight' => "INT(11) NOT NULL",
                'complementary_printing_after_digital' => "INT(11) NOT NULL",
                'complementary_printing_after_digital_weight' => "INT(11) NOT NULL",
                'punch' => "INT(11) NULL DEFAULT NULL",
                'degree' => "INT(11) NULL DEFAULT NULL",
                'weight' => "INT(11) NULL DEFAULT NULL",
                'technique' => "INT(11) NOT NULL",
                'template' => "INT(11) NOT NULL",
                'effect' => "INT(11) NOT NULL",
                'decor' => "INT(11) NOT NULL",
                'body' => "INT(11) NOT NULL",
                'body_weight' => "INT(11) NOT NULL",
                'engobe' => "INT(11) NOT NULL",
                'engobe_weight' => "INT(11) NOT NULL",
                'glaze' => "INT(11) NOT NULL",
                'glaze_weight' => "INT(11) NOT NULL",
                'packing' => "INT(11) NOT NULL",
                'carton_packing' => "INT(11) NOT NULL",
                'pallet_packing' => "INT(11) NOT NULL",
            ],
            'KEY' => [
                'kind',
                'size',
                'phase',
                'color',
                'cylinder_before',
                'cylinder_after',
                'complementary_printing_before_digital',
                'complementary_printing_after_digital',
                'punch',
                'degree',
                'technique',
                'effect',
                'decor',
                'glaze',
                'engobe',
                'body',
                'packing',
                'carton_packing',
                'pallet_packing',
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'kind' => ['table' => 'product_kind', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'size' => ['table' => 'product_size', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'color' => ['table' => 'product_color', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'cylinder_before' => ['table' => 'product_cylinder', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'cylinder_after' => ['table' => 'product_cylinder', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'complementary_printing_before_digital' => ['table' => 'product_complementary_printing_before_digital', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'complementary_printing_after_digital' => ['table' => 'product_complementary_printing_after_digital', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'punch' => ['table' => 'product_punch', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'degree' => ['table' => 'product_degree', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'pallet' => ['table' => 'product_pallet', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'technique' => ['table' => 'product_technique', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'effect' => ['table' => 'product_effect', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'decor' => ['table' => 'product_decor', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'phase' => ['table' => 'phases', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'glaze' => ['table' => 'product_glaze', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'engobe' => ['table' => 'product_engobe', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'body' => ['table' => 'product_body', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'packing' => ['table' => 'product_packing', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton_packing' => ['table' => 'product_carton_packing', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'pallet_packing' => ['table' => 'product_pallet_packing', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
    ],
    'sqlInstall' => [
        "INSERT IGNORE INTO `{prefix}product_size` (`id`, `label`,`width`,`length`,`thickness`) VALUES
        (1 , '30-90' , 30 , 90 ,0),
        (2 , '80-120' , 80 , 120 ,0),
        (3 , '60-60' , 60 , 60 ,0),
        (4 , '60-120' , 60 , 120 ,0),
        (5 , '80-80' , 80 , 80 ,0);",
        "INSERT IGNORE INTO `{prefix}product_glaze` (`id`, `label`) VALUES
        (1 , 'پولیش'),
        (2 , 'شوگر'),
        (3 , 'براق'),
        (4 , 'مات hard'),
        (5 , 'مات soft'),
        (6 , 'پولیش طرح تیره');",
        "INSERT IGNORE INTO `{prefix}product_glaze` (`id`,`parent`, `label`) VALUES
        (7 ,3, 'GC94');",
        "INSERT IGNORE INTO `{prefix}product_punch` (`id`, `label`) VALUES
        (1 , 'تخت'),
        (2 , 'کونیک'),
        (3 , 'آرشام');",
        "INSERT IGNORE INTO `{prefix}product_color` (`id`, `label`) VALUES
        (1 , 'کرم'),
        (2 , 'قهوه ای'),
        (3 , 'آبی');",
        "INSERT IGNORE INTO `{prefix}product_digitalPrint_color` (`id`, `label`) VALUES
        (1 , 'آبی'),
        (2 , 'قهوه ای'),
        (3 , 'بژ'),
        (4 , 'مشکی'),
        (5 , 'زرد'),
        (6 , 'صورتی');",
        "INSERT IGNORE INTO `{prefix}product_kind` (`id`, `label`) VALUES
        (2 , 'پرسلان گرید a'),
        (1 , 'دیوار'),
        (3 , 'پرسلان گرید b دیجیتال');",
        "INSERT IGNORE INTO `{prefix}product_technique` (`id`, `label`) VALUES
        (2 , 'فول بادی'),
        (1 , 'لعابدار'),
        (3 , 'ضد اسید'),
        (4 , 'سایر');",
        "INSERT IGNORE INTO `{prefix}product_effect` (`id`, `label`) VALUES
(1 , 'چوب'),        
        (2 , 'سنگ'),
        (3 , 'سیمان'),
        (4 , 'پارچه'),
        (6 , 'چرم'),
        (5 , 'آجر'),
        (7 , 'متال'),
        (8 , 'کاغذ دیواری'),
        (9 , 'سایر');",
        "INSERT IGNORE INTO `{prefix}product_decor` (`id`, `label`) VALUES
  (1 , 'ندارد'),      
        (2 , 'تک گل'),
        (3 , 'باند و بردر'),
        (4 , 'سیگاری'),
        (5 , 'سایر');",
        "INSERT IGNORE INTO `{prefix}product_degree` (`id`, `label`) VALUES
        (1 , 'درجه 1'),
        (2 , 'درجه 2'),
        (3 , 'درجه 3'),
        (4 , 'درجه W'),
        (5 , 'درجه U');",
        "INSERT IGNORE INTO `{prefix}product_glue` (`id`, `label`) VALUES
        (1 , 'چسب حرارتی');",
        "INSERT IGNORE INTO `{prefix}product_strap` (`id`, `label`) VALUES
        (1 , 'تسمه کارتن'),
        (2 , 'تسمه پالت');",
        "INSERT IGNORE INTO `{prefix}product_template` (`id`, `label`) VALUES
        (1 , 'تخت');",
        "INSERT IGNORE INTO `{prefix}product_engobe` (`id`, `label`) VALUES
        (1 , 'EC54');",
        "INSERT IGNORE INTO `{prefix}product_body` (`id`, `label`) VALUES
        (1 , 'BC53');",
    ],
];