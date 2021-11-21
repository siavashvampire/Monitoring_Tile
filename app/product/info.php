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
        'product' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'kind' => "INT(11) NOT NULL",
                'size' => "INT(11) NOT NULL",
                'phase' => "INT(11) NOT NULL",
                'color' => "INT(11) NOT NULL",
                'glaze' => "INT(11) NOT NULL",
                'punch' => "INT(11) NOT NULL",
                'degree' => "INT(11) NOT NULL",
                'weight' => "INT(11) NOT NULL",
                'pallet' => "INT(11) NOT NULL",
                'technique' => "INT(11) NOT NULL",
                'effect' => "INT(11) NOT NULL",
                'decor' => "INT(11) NOT NULL",
            ],
            'KEY' => [
                'kind',
                'size',
                'phase',
                'color',
                'glaze',
                'punch',
                'degree',
                'pallet',
                'technique',
                'effect',
                'decor',
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'kind' => [ 'table' => 'product_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'size' => [ 'table' => 'product_size' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'color' => [ 'table' => 'product_color' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'glaze' => [ 'table' => 'product_glaze' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'punch' => [ 'table' => 'product_punch' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'degree' => [ 'table' => 'product_degree' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'pallet' => [ 'table' => 'product_pallet' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'technique' => [ 'table' => 'product_technique' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'effect' => [ 'table' => 'product_effect' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'decor' => [ 'table' => 'product_decor' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'phase' => [ 'table' => 'phases' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
            ]
        ],
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
        "INSERT IGNORE INTO `{prefix}product_punch` (`id`, `label`) VALUES
        (1 , 'تخت'),
        (2 , 'کونیک'),
        (3 , 'آرشام');",
        "INSERT IGNORE INTO `{prefix}product_color` (`id`, `label`) VALUES
        (1 , 'کرم'),
        (2 , 'قهوه ای'),
        (3 , 'آبی');",
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
        (2 , 'سنگ'),
        (1 , 'چوب'),
        (3 , 'سیمان'),
        (4 , 'پارچه'),
        (6 , 'چرم'),
        (5 , 'آجر'),
        (7 , 'مثال'),
        (1 , 'ندارد'),
        (7 , 'کاغذ دیواری'),
        (8 , 'سایر');",
        "INSERT IGNORE INTO `{prefix}product_decor` (`id`, `label`) VALUES
        (2 , 'تک گل'),
        (3 , 'باند و بردر'),
        (4 , 'سیگاری'),
        (5 , 'سایر');",
    ],
];