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
        'product_sub_engobe' => [
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
        'product_novanc' => [
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
                'carton_theme' => ['table' => 'carton_theme', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton_size' => ['table' => 'carton_size', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
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
                'pallet_packing' => "INT(11) NOT NULL",
                'carton_packing' => "INT(11) NOT NULL",
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
                'pallet_packing',
                'carton_packing',
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
                'pallet_packing' => ['table' => 'product_pallet_packing', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton_packing' => ['table' => 'product_carton_packing', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'product' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'register_date' => "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'example_code' => "INT(11)",
                'code' => "INT(11)",
                'production_design_code' => "varchar(65)",
                'kind' => "INT(11) NOT NULL",
                'size' => "INT(11) NOT NULL",
                'phase' => "INT(11) NOT NULL",
                'color' => "INT(11)",
                'novanc' => "INT(11)",
                'cylinder_before' => "INT(11)",
                'cylinder_after' => "INT(11)",
                'complementary_printing_before_digital' => "INT(11)",
                'complementary_printing_before_digital_weight' => "INT(11)",
                'complementary_printing_after_digital' => "INT(11)",
                'complementary_printing_after_digital_weight' => "INT(11)",
                'punch' => "INT(11) NULL DEFAULT NULL",
                'degree' => "INT(11) NULL DEFAULT NULL",
                'weight' => "INT(11) NULL DEFAULT NULL",
                'technique' => "INT(11)",
                'template' => "INT(11)",
                'effect' => "INT(11)",
                'decor' => "INT(11)",
                'body' => "INT(11)",
                'body_weight' => "INT(11)",
                'engobe' => "INT(11)",
                'engobe_weight' => "INT(11)",
                'glaze' => "INT(11)",
                'glaze_weight' => "INT(11)",
                'carton_packing' => "INT(11)",
                'pallet_packing' => "INT(11)",
                'packing' => "INT(11)",
                'file_code' => "INT(11)",
                'description' => "varchar(65) COLLATE utf8_persian_ci",
                'sub_engobe' => "INT(11)",
            ],
            'KEY' => [
                'kind',
                'size',
                'phase',
                'color',
                'novanc',
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
                'carton_packing',
                'pallet_packing',
                'packing',
                'sub_engobe',
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'kind' => ['table' => 'product_kind', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'size' => ['table' => 'product_size', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'color' => ['table' => 'product_color', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'novanc' => ['table' => 'product_novanc', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'cylinder_before' => ['table' => 'product_cylinder', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'cylinder_after' => ['table' => 'product_cylinder', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'complementary_printing_before_digital' => ['table' => 'product_complementary_printing_before_digital', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'complementary_printing_after_digital' => ['table' => 'product_complementary_printing_after_digital', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'punch' => ['table' => 'product_punch', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'degree' => ['table' => 'product_degree', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'technique' => ['table' => 'product_technique', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'effect' => ['table' => 'product_effect', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'decor' => ['table' => 'product_decor', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'phase' => ['table' => 'phases', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'glaze' => ['table' => 'product_glaze', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'engobe' => ['table' => 'product_engobe', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'body' => ['table' => 'product_body', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'carton_packing' => ['table' => 'product_carton_packing', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'pallet_packing' => ['table' => 'product_pallet_packing', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'packing' => ['table' => 'product_packing', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'sub_engobe' => ['table' => 'product_sub_engobe', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
    ],
    'sqlInstall' => [
        "INSERT IGNORE INTO `{prefix}product_size` (`id`, `label`,`width`,`length`,`thickness`) VALUES
        (1 , '30-90' , 300 , 900 ,10),
        (2 , '80-120' , 800 , 1200 ,10),
        (3 , '60-60' , 600 , 600 ,10),
        (4 , '60-120' , 600 , 1200 ,10),
        (5 , '80-80' , 800 , 800 ,10),
        (6 , '30*60' , 300 , 600 ,10),
        (7 , '61*61' , 610 , 610 ,10);",
        "INSERT IGNORE INTO `{prefix}product_glaze` (`id`, `label`) VALUES
        (1 , 'پولیش'),
        (2 , 'شوگر'),
        (3 , 'براق'),
        (4 , 'مات hard'),
        (5 , 'مات soft'),
        (6 , 'پولیش طرح تیره');",
        "INSERT IGNORE INTO `{prefix}product_glaze` (`id`,`parent`, `label`) VALUES
        (7 ,3, 'GC94'),
        (8 ,3, 'GC52'),
        (11 ,3, 'GC58'),
        (12 ,3, 'GC98'),
        (13 ,3, 'GC99'),
        (14 ,3, 'GC101'),
        (15 ,3, 'GC103'),
        (16 ,3, 'GC105'),
        (17 ,3, 'GC107'),
        (9 ,3, 'GW44'),
        (23 ,3, 'GW45'),
        (18 ,3, 'GW36'),
        (19 ,3, 'GW39'),
        (20 ,3, 'GW40'),
        (21 ,3, 'GW41'),
        (22 ,3, 'GW52'),
        (10 ,3, 'GC93');",
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
        "INSERT IGNORE INTO `{prefix}product_novanc` (`id`, `label`) VALUES
        (1 , 'A'),
        (2 , 'B'),
        (3 , 'C'),
        (4 , 'D'),
        (5 , 'E'),
        (6 , 'F'),
        (7 , 'G'),
        (8 , 'H'),
        (9 , 'Z');",
        "INSERT IGNORE INTO `{prefix}product_strap` (`id`, `label`) VALUES
        (1 , 'تسمه کارتن'),
        (2 , 'تسمه پالت');",
        "INSERT IGNORE INTO `{prefix}product_template` (`id`, `label`) VALUES
        (1 , 'تخت');",
        "INSERT IGNORE INTO `{prefix}product_engobe` (`id`, `label`) VALUES
        (1 , 'EW22'),
        (2 , 'EW24'),
        (8 , 'EW25'),
        (3 , 'EW58'),
        (4 , 'EC54'),                                                   
        (5 , 'EC58'),
        (6 , 'EC60'),
        (7 , 'EC61');",
        "INSERT IGNORE INTO `{prefix}product_sub_engobe` (`id`, `label`) VALUES
        (1 , 'EZ2');",
        "INSERT IGNORE INTO `{prefix}product_body` (`id`, `label`) VALUES
        (1 , 'BC52'),
        (2 , 'BC53'),
        (3 , 'BC54'),
        (4 , 'BC56'),
        (5 , 'BW19-1'),
        (6 , 'BW20');",
        "INSERT IGNORE INTO `{prefix}carton_size` (`id`, `label`) VALUES
        (1 , 'پراميد'),
        (2 , 'رنوس'),
        (3 , 'نيکان'),
        (4 , 'پاسارگاد'),
        (5 , 'دورينا'),
        (6 , 'مليپا'),
        (7 , 'ويسنته'),
        (8 , 'حافظ'),
        (9 , 'آدورينا'),
        (10 , 'پرسيس'),
        (11 , 'کارناوال'),
        (12 , 'سرآموزا');",
    ],
];