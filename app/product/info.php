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
        'product_kind' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'tile_width' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'tile_length' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
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
    ],
    'sqlInstall' => [
        "INSERT IGNORE INTO `{prefix}product_kind` (`id`, `label`,`tile_width`,`tile_length`) VALUES
        (1 , '30-90' , 30 , 90),
        (2 , '80-120' , 80 , 120),
        (3 , '60-60' , 60 , 60),
        (4 , '60-120' , 60 , 120),
        (5 , '80-80' , 80 , 80);",
        "INSERT IGNORE INTO `{prefix}product_glaze` (`id`, `label`) VALUES
        (1 , 'Mat'),
        (2 , 'مات'),
        (3 , 'پولیش'),
        (4 , 'مات شوگر(مطابق نمونه ارسالی از طرف نماینده)'),
        (5 , 'مات و شوگر(سیلندر)');",
    ],
];