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
        'Days' => [
            'type' => 'number',
            'status' => '',
            'title' => 'زمان بررسی',
            'description' => '',
            'value' => '1',
            'valueDe' => null
        ],
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
                'creator' => "INT(11) NOT NULL",
                'example_code' => "INT(11)",
                'production_design_code' => "varchar(65)",
                'kind' => "INT(11) NOT NULL DEFAULT '1'",
                'size' => "INT(11) NOT NULL DEFAULT '1'",
                'phase' => "INT(11) NOT NULL DEFAULT '2'",
                'color' => "INT(11)",
                'cylinder_before' => "INT(11)",
                'cylinder_after' => "INT(11)",
                'complementary_printing_before_digital' => "INT(11)",
                'complementary_printing_before_digital_weight' => "FLOAT",
                'complementary_printing_after_digital' => "INT(11)",
                'complementary_printing_after_digital_weight' => "FLOAT",
                'punch' => "INT(11) NULL DEFAULT NULL",
                'degree' => "INT(11) NULL DEFAULT NULL",
                'weight' => "INT(11) NULL DEFAULT NULL",
                'technique' => "INT(11)",
                'template' => "INT(11)",
                'effect' => "INT(11)",
                'decor' => "INT(11)",
                'body' => "INT(11)",
                'body_weight' => "FLOAT",
                'engobe' => "INT(11)",
                'engobe_weight' => "FLOAT",
                'glaze' => "INT(11)",
                'glaze_weight' => "FLOAT",
                'carton_packing' => "INT(11)",
                'pallet_packing' => "INT(11)",
                'packing' => "INT(11)",
            ],
            'KEY' => [
                'creator',
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
                'carton_packing',
                'pallet_packing',
                'packing',
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'creator' => ['table' => 'user', 'column' => 'userId', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'kind' => ['table' => 'product_kind', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'size' => ['table' => 'product_size', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'color' => ['table' => 'product_color', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
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
            ]
        ],
        'product_qc' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'product' => 'INT(11) NOT NULL',
                'insert_date' => "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'qc_date' => "DATE NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'body' => "INT(11)",
                'engobe' => "INT(11)",
                'glaze' => "INT(11)",
                'sub_engobe' => "INT(11)",
                'thickness' => "FLOAT",
                'novanc' => "INT(11)",
                'code' => "FLOAT",
                'file_code' => "FLOAT",
                'controller' => "INT(11)",
                'description' => "varchar(650) COLLATE utf8_persian_ci",
            ],
            'KEY' => [
                'product',
                'body',
                'engobe',
                'glaze',
                'sub_engobe',
                'novanc',
                'controller',
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'product' => ['table' => 'product', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'body' => ['table' => 'product_body', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'engobe' => ['table' => 'product_engobe', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'glaze' => ['table' => 'product_glaze', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'sub_engobe' => ['table' => 'product_sub_engobe', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'novanc' => ['table' => 'product_novanc', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'controller' => ['table' => 'user', 'column' => 'userId', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'product_routine' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'product' => 'INT(11) NOT NULL',
                'insert_date' => "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'routine_date' => "DATE NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'shift' => "INT(11) NOT NULL",
                'length_min' => "FLOAT",
                'length_max' => "FLOAT",
                'width_min' => "FLOAT",
                'width_max' => "FLOAT",
                'thickness_min' => "FLOAT",
                'thickness_max' => "FLOAT",
                'resistance' => "FLOAT",
                'wrap_diameter_min' => "FLOAT",
                'wrap_diameter_max' => "FLOAT",
                'wrap_center_min' => "FLOAT",
                'wrap_center_max' => "FLOAT",
                'wrap_edge_min' => "FLOAT",
                'wrap_edge_max' => "FLOAT",
                'oblique' => "FLOAT",
                'oblique_bool' => "TINYINT",
                'straight' => "FLOAT",
                'straight_bool' => "TINYINT",
                'water_attraction_max' => "FLOAT",
                'water_attraction_min' => "FLOAT",
                'temperature_min' => "FLOAT",
                'temperature_max' => "FLOAT",
                'cycle' => "INT(11)",
                'specific_pressure' => "INT(11)",
                'controller' => "INT(11)",
                'description' => "varchar(650) COLLATE utf8_persian_ci",
            ],
            'KEY' => [
                'product',
                'shift',
                'controller',
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'product' => ['table' => 'product', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'shift' => ['table' => 'shift_work', 'column' => 'shift_id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'controller' => ['table' => 'user', 'column' => 'userId', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'grading_statistics' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'product_id' => 'INT(11) NOT NULL',
                'novanc_id' => 'INT(11) NOT NULL',
                'insert_date' => "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'routine_date' => "DATE NOT NULL DEFAULT CURRENT_TIMESTAMP",
            ],
            'KEY' => [
                'product_id',
                'novanc_id',
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'product_id' => ['table' => 'product', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'novanc_id' => ['table' => 'product_novanc', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE']
            ]
        ],
        'grading_statistics_space' => [
            'fields' => [
                'grading_statistic_id' => 'INT(11) NOT NULL',
                'degree_id' => 'INT(11) NOT NULL',
                'space' => 'FLOAT',
            ],
            'KEY' => [
                'grading_statistic_id',
                'degree_id',
            ],
            'PRIMARY KEY' => [
            ],
            'REFERENCES' => [
                'grading_statistic_id' => ['table' => 'grading_statistics', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'degree_id' => ['table' => 'product_degree', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
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
        (7 , '61*61' , 610 , 610 ,10),
        (8 , '80-160' , 800,  1600 ,11),
        (9 , '100-100' , 1000 , 1000 ,11);",
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
        (6 , '3090000220S1'),
        (5 , '3090000220S2'),
        (4 , 'فیوره'),
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
        "CREATE TRIGGER IF NOT EXISTS `{prefix}data_after_insert` AFTER INSERT ON `{prefix}data` FOR EACH ROW BEGIN
            INSERT INTO {prefix}data_merge(`Sensor_id`,`Start_time`,`JStart_time`,`AbsTime`,`counter`,`Shift_id`,`Shift_group_id`,`employers_id`,`Tile_Kind`,`Motor_Speed`,`phase`,`unit`,`tileDegree`) 
            VALUES(NEW.Sensor_id,NEW.Start_time,NEW.JStart_time,NEW.AbsTime,NEW.counter,NEW.Shift_id,NEW.Shift_group_id,NEW.employers_id,NEW.Tile_Kind,NEW.Motor_Speed,NEW.phase,NEW.unit,NEW.tileDegree);
            INSERT INTO {prefix}data_merge_HOUR(`Sensor_id`,`Start_time`,`JStart_time`,`AbsTime`,`counter`,`Shift_id`,`Shift_group_id`,`employers_id`,`Tile_Kind`,`Motor_Speed`,`phase`,`unit`,`tileDegree`) 
            VALUES(NEW.Sensor_id,NEW.Start_time,NEW.JStart_time,NEW.AbsTime,NEW.counter,NEW.Shift_id,NEW.Shift_group_id,NEW.employers_id,NEW.Tile_Kind,NEW.Motor_Speed,NEW.phase,NEW.unit,NEW.tileDegree);
            INSERT INTO {prefix}data_archive(`Sensor_id`,`Start_time`,`JStart_time`,`AbsTime`,`counter`,`Shift_id`,`Shift_group_id`,`employers_id`,`Tile_Kind`,`Motor_Speed`,`phase`,`unit`,`tileDegree`) 
            VALUES(NEW.Sensor_id,NEW.Start_time,NEW.JStart_time,NEW.AbsTime,NEW.counter,NEW.Shift_id,NEW.Shift_group_id,NEW.employers_id,NEW.Tile_Kind,NEW.Motor_Speed,NEW.phase,NEW.unit,NEW.tileDegree);
        END",
        "CREATE TRIGGER IF NOT EXISTS `{prefix}data_temp_after_insert` AFTER INSERT ON `{prefix}data_temp` FOR EACH ROW BEGIN
            INSERT INTO {prefix}data(`Sensor_id`,`Start_time`,`JStart_time`,`AbsTime`,`counter`,`Shift_id`,`Shift_group_id`,`employers_id`,`Tile_Kind`,`Motor_Speed`,`phase`,`unit`,`tileDegree`)
            VALUES(NEW.Sensor_id,NEW.Start_time,NEW.JStart_time,NEW.AbsTime,NEW.counter,NEW.Shift_id,NEW.Shift_group_id,NEW.employers_id,NEW.Tile_Kind,NEW.Motor_Speed,NEW.phase,NEW.unit,NEW.tileDegree);
        END",
        "CREATE FUNCTION IF NOT EXISTS `gdate`(`jy` smallint, `jm` smallint, `jd` smallint) RETURNS datetime
    READS SQL DATA
    DETERMINISTIC
BEGIN
	DECLARE	i, j, e, k, mo, gy, gm, gd, g_day_no, j_day_no, bkab, jmm, mday, g_day_mo, bkab1, j1 INT DEFAULT 0;
	DECLARE resout char(100);
	DECLARE fdate datetime;
	SET bkab = __neo_mod(jy,33);
	IF (bkab = 1 or bkab= 5 or bkab = 9 or bkab = 13 or bkab = 17 or bkab = 22 or bkab = 26 or bkab = 30) THEN SET j=1; end IF;
	SET bkab1 = __neo_mod(jy+1,33);
	IF (bkab1 = 1 or bkab1= 5 or bkab1 = 9 or bkab1 = 13 or bkab1 = 17 or bkab1 = 22 or bkab1 = 26 or bkab1 = 30) THEN SET j1=1; end IF;
	CASE jm
		WHEN 1 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 2 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 3 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 4 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 5 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 6 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 7 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 8 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 9 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 10 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 11 THEN IF jd > __neo_j2(jm) or jd <= 0 THEN SET e=1; end IF;
		WHEN 12 THEN IF jd > __neo_j2(jm)+j or jd <= 0 THEN SET e=1; end IF;
	END CASE;
	IF jm > 12 or jm <= 0 THEN SET e=1; end IF;
	IF jy <= 0 THEN SET e=1; end IF;
	IF e>0 THEN RETURN 0; end IF;
	IF (jm>=11) or (jm=10 and jd>=11 and j=0) or (jm=10 and jd>11 and j=1) THEN SET i=1; end IF;
	SET gy = jy + 621 + i;
	IF (__neo_mod(gy,4)=0) THEN SET k=1; end IF;
	IF (__neo_mod(gy,100)=0) and (__neo_mod(gy,400)<>0) THEN SET k=0; END IF;
	SET jmm=jm-1;
	WHILE (jmm > 0) do
		SET mday=mday+__neo_j2(jmm);
		SET jmm=jmm-1;
	end WHILE;
	SET j_day_no=(jy-1)*365+(__neo_div(jy,4))+mday+jd;
	SET g_day_no=j_day_no+226899;
	SET g_day_no=g_day_no-(__neo_div(gy-1,4));
	SET g_day_mo=__neo_mod(g_day_no,365);
	IF (k=1 and j=1) THEN
		IF (g_day_mo=0) THEN RETURN CONCAT_WS('-',gy,'12','30'); END IF;
		IF (g_day_mo=1) THEN RETURN CONCAT_WS('-',gy,'12','31'); END IF;
	END IF;
	IF (g_day_mo=0) THEN RETURN CONCAT_WS('-',gy,'12','31'); END IF;
	SET mo=0;
	SET gm=gm+1;
	while g_day_mo>__neo_g2(mo,k) do
	SET g_day_mo=g_day_mo-__neo_g2(mo,k);
    SET mo=mo+1;
    SET gm=gm+1;
	end WHILE;
	SET gd=g_day_mo;
	RETURN CONCAT_WS('-',gy,gm,gd);
END;",
        "CREATE FUNCTION IF NOT EXISTS `jdate`(`gdate` datetime) RETURNS char(100) CHARSET utf8
    READS SQL DATA
    DETERMINISTIC
BEGIN
	DECLARE i, gy, gm, gd, g_day_no, j_day_no, j_np, jy, jm, jd INT DEFAULT 0;
	DECLARE resout char(100);
	DECLARE ttime CHAR(20);
	SET gy = YEAR(gdate) - 1600;
	SET gm = MONTH(gdate) - 1;
	SET gd = DAY(gdate) - 1;
	SET ttime = TIME(gdate);
	SET g_day_no = ((365 * gy) + __neo_div(gy + 3, 4) - __neo_div(gy + 99, 100) + __neo_div (gy + 399, 400));
	SET i = 0;
	WHILE (i < gm) do
		SET g_day_no = g_day_no + __neo_g(i);
		SET i = i + 1;
	END WHILE;
	IF gm > 1 and ((gy % 4 = 0 and gy % 100 <> 0)) or gy % 400 = 0 THEN SET g_day_no =	g_day_no + 1; END IF;
	SET g_day_no = g_day_no + gd;
	SET j_day_no = g_day_no - 79;
	SET j_np = j_day_no DIV 12053;
	SET j_day_no = j_day_no % 12053;
	SET jy = 979 + 33 * j_np + 4 * __neo_div(j_day_no, 1461);
	SET j_day_no = j_day_no % 1461;
	IF j_day_no >= 366 then SET jy = jy + __neo_div(j_day_no - 1, 365); SET j_day_no = (j_day_no - 1) % 365; END IF;
	SET i = 0;
	WHILE (i < 11 and j_day_no >= __neo_j(i)) do
		SET j_day_no = j_day_no - __neo_j(i);
		SET i = i + 1;
	END WHILE;
	SET jm = i + 1;
	SET jd = j_day_no + 1;
	SET resout = CONCAT_WS ('-', jy, jm, jd);
	IF (ttime <> '00:00:00') then SET resout = CONCAT_WS(' ', resout, ttime); END IF;
	RETURN resout;
END;",
        "CREATE FUNCTION IF NOT EXISTS `jday`(`gdate` datetime) RETURNS char(100) CHARSET utf8
BEGIN
	DECLARE	i, gy, gm, gd, g_day_no, j_day_no, j_np, jy, jm, jd INT DEFAULT 0;
	DECLARE resout char(100);
	DECLARE ttime CHAR(20);
	SET gy = YEAR(gdate) - 1600;
	SET gm = MONTH(gdate) - 1;
	SET gd = DAY(gdate) - 1;
	SET ttime = TIME(gdate);
	SET g_day_no = ((365 * gy) + __neo_div(gy + 3, 4) - __neo_div(gy + 99 , 100) + __neo_div(gy + 399, 400));
	SET i = 0;
	WHILE (i < gm) do
		SET g_day_no = g_day_no + __neo_g(i);
		SET i = i + 1;
	END WHILE;
	IF gm > 1 and ((gy % 4 = 0 and gy % 100 <> 0)) or gy % 400 = 0 THEN SET g_day_no = g_day_no + 1; END IF;
	SET g_day_no = g_day_no + gd;
	SET j_day_no = g_day_no - 79;
	SET j_np = j_day_no DIV 12053;
	SET j_day_no = j_day_no % 12053;
	SET jy = 979 + 33 * j_np + 4 * __neo_div(j_day_no, 1461);
	SET j_day_no = j_day_no % 1461;
	IF j_day_no >= 366 then
		SET jy = jy + __neo_div(j_day_no - 1, 365);
		SET j_day_no = (j_day_no-1) % 365;
	END IF;
	SET i = 0;
	WHILE (i < 11 and j_day_no >= __neo_j(i)) do
		SET j_day_no = j_day_no - __neo_j(i);
		SET i = i + 1;
	END WHILE;
	SET jm = i + 1;
	SET jd = j_day_no + 1;
	RETURN jd;
END ;",
        "CREATE FUNCTION IF NOT EXISTS `jmonth`(`gdate` datetime) RETURNS char(100) CHARSET utf8
BEGIN
	DECLARE i, gy, gm, gd, g_day_no, j_day_no, j_np, jy, jm, jd INT DEFAULT 0;
	DECLARE resout char(100);
	DECLARE ttime CHAR(20);
	SET gy = YEAR(gdate) - 1600;
	SET gm = MONTH(gdate) - 1;
	SET gd = DAY(gdate) - 1;
	SET ttime = TIME(gdate);
	SET g_day_no = ((365 * gy) + __neo_div(gy + 3, 4) - __neo_div(gy + 99, 100) + __neo_div(gy + 399, 400));
	SET i = 0;
	WHILE (i < gm) do
		SET g_day_no = g_day_no + __neo_g(i);
		SET i = i + 1; 
	END WHILE;
	IF gm > 1 and ((gy % 4 = 0 and gy % 100 <> 0)) or gy % 400 = 0 THEN SET g_day_no = g_day_no + 1; END IF;
	SET g_day_no = g_day_no + gd;
	SET j_day_no = g_day_no - 79;
	SET j_np = j_day_no DIV 12053;
	set j_day_no = j_day_no % 12053;
	SET jy = 979 + 33 * j_np + 4 * __neo_div(j_day_no, 1461);
	SET j_day_no = j_day_no % 1461;
	IF j_day_no >= 366 then 
		SET jy = jy + __neo_div(j_day_no - 1, 365);
		SET j_day_no =(j_day_no - 1) % 365;
	END IF;
	SET i = 0;
	WHILE (i < 11 and j_day_no >= __neo_j(i)) do
		SET j_day_no = j_day_no - __neo_j(i);
		SET i = i + 1;
	END WHILE;
	SET jm = i + 1;
	SET jd = j_day_no + 1;
	RETURN jm;
END ;",
        "CREATE FUNCTION IF NOT EXISTS `jyear`(`gdate` datetime) RETURNS char(100) CHARSET utf8
BEGIN
	DECLARE	i, gy, gm, gd, g_day_no, j_day_no, j_np, jy, jm, jd INT DEFAULT 0;
	DECLARE resout char(100);
	DECLARE ttime CHAR(20);
	SET gy = YEAR(gdate) - 1600;
	SET gm = MONTH(gdate) - 1;
	SET gd = DAY(gdate) - 1;
	SET ttime = TIME(gdate);
	SET g_day_no = ((365 * gy) + __neo_div(gy + 3, 4) - __neo_div(gy + 99, 100) + __neo_div(gy + 399, 400));
	SET i = 0;
	WHILE (i < gm) do
		SET g_day_no = g_day_no + __neo_g(i);
		SET i = i + 1;
	END WHILE;
	IF gm > 1 and ((gy % 4 = 0 and gy % 100 <> 0)) or gy % 400 = 0 THEN SET g_day_no =	g_day_no + 1; END IF;
	SET g_day_no = g_day_no + gd;
	SET j_day_no = g_day_no - 79;
	SET j_np = j_day_no DIV 12053;
	set j_day_no = j_day_no % 12053;
	SET jy = 979 + 33 * j_np + 4 * __neo_div(j_day_no, 1461);
	SET j_day_no = j_day_no % 1461;
	IF j_day_no >= 366 then
		SET jy = jy + __neo_div(j_day_no - 1, 365);
		SET j_day_no = (j_day_no - 1) % 365;
	END IF;
	SET i = 0;
	WHILE (i < 11 and j_day_no >= __neo_j(i)) do
		SET j_day_no = j_day_no - __neo_j(i);
		SET i = i + 1;
	END WHILE;
	SET jm = i + 1;
	SET jd = j_day_no + 1;
	RETURN jy;
END ;",
        "CREATE FUNCTION IF NOT EXISTS `__neo_div`(`a` int, `b` int) RETURNS bigint(20)
    READS SQL DATA
    DETERMINISTIC
BEGIN
	return FLOOR(a / b);
END ;",
        "CREATE FUNCTION IF NOT EXISTS `__neo_g`(`m` smallint) RETURNS smallint(2)
    READS SQL DATA
    DETERMINISTIC
BEGIN
	CASE m
		WHEN 0 THEN RETURN 31;
		WHEN 1 THEN RETURN 28;
		WHEN 2 THEN RETURN 31;
		WHEN 3 THEN RETURN 30;
		WHEN 4 THEN RETURN 31;
		WHEN 5 THEN RETURN 30;
		WHEN 6 THEN RETURN 31;
		WHEN 7 THEN RETURN 31;
		WHEN 8 THEN RETURN 30;
		WHEN 9 THEN RETURN 31;
		WHEN 10 THEN RETURN 30;
		WHEN 11 THEN RETURN 31;
	END CASE;
	END ;",
        "CREATE FUNCTION IF NOT EXISTS `__neo_g2`(`m` smallint, `k` SMALLINT) RETURNS smallint(2)
    READS SQL DATA
    DETERMINISTIC
BEGIN
		CASE m
			WHEN 0 THEN RETURN 31;
			WHEN 1 THEN RETURN 28+k;
			WHEN 2 THEN RETURN 31;
			WHEN 3 THEN RETURN 30;
			WHEN 4 THEN RETURN 31;
			WHEN 5 THEN RETURN 30;
			WHEN 6 THEN RETURN 31;
			WHEN 7 THEN RETURN 31;
			WHEN 8 THEN RETURN 30;
			WHEN 9 THEN RETURN 31;
			WHEN 10 THEN RETURN 30;
			WHEN 11 THEN RETURN 31;
		END CASE;
	END ;",
        "CREATE FUNCTION IF NOT EXISTS `__neo_j`(`m` smallint) RETURNS smallint(2)
    READS SQL DATA
    DETERMINISTIC
BEGIN
	CASE m
		WHEN 0 THEN RETURN 31;
		WHEN 1 THEN RETURN 31;
		WHEN 2 THEN RETURN 31;
		WHEN 3 THEN RETURN 31;
		WHEN 4 THEN RETURN 31;
		WHEN 5 THEN RETURN 31;
		WHEN 6 THEN RETURN 30;
		WHEN 7 THEN RETURN 30;
		WHEN 8 THEN RETURN 30;
		WHEN 9 THEN RETURN 30;
		WHEN 10 THEN RETURN 30;
		WHEN 11 THEN RETURN 29;
	END CASE;
	END ;",
        "CREATE FUNCTION IF NOT EXISTS `__neo_j2`(`m` smallint) RETURNS smallint(2)
BEGIN
	CASE m
		WHEN 1 THEN RETURN 31;
		WHEN 2 THEN RETURN 31;
		WHEN 3 THEN RETURN 31;
		WHEN 4 THEN RETURN 31;
		WHEN 5 THEN RETURN 31;
		WHEN 6 THEN RETURN 31;
		WHEN 7 THEN RETURN 30;
		WHEN 8 THEN RETURN 30;
		WHEN 9 THEN RETURN 30;
		WHEN 10 THEN RETURN 30;
		WHEN 11 THEN RETURN 30;
		WHEN 12 THEN RETURN 29;
	END CASE;
END ;",
        "CREATE FUNCTION IF NOT EXISTS `__neo_mod`(`a` int, `b` int) RETURNS bigint(20)
    READS SQL DATA
    DETERMINISTIC
BEGIN
	return (a - b * FLOOR(a / b));
	END ;",
    ],
];