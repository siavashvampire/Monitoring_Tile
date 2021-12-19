<?php
return [
    'info' => [
        'name' => 'contacts',
        'description' => 'contacts',
        'version' => '1.0.0.0',
        'author' => 'Siavash Sepahi',
        'support' => '09379206248',
        'PLCNeed' => false,
    ],
    'configuration' => [
    ],
    'db' => [
        'phone_type' => [
            'fields' => [
                'id' => "INT(11) NOT NULL AUTO_INCREMENT",
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
        'phone' => [
            'fields' => [
                'id' => "INT(11) NOT NULL AUTO_INCREMENT",
                'name' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'phone' => "varchar(255) COLLATE utf8_persian_ci DEFAULT NULL",
                'send_allow' => "TINYINT(1) NOT NULL DEFAULT 1",
                'access' => "TINYINT(1) NOT NULL DEFAULT 0",
                'units' => "varchar(65) COLLATE utf8_persian_ci NOT NULL DEFAULT 0",
                'phase' => "varchar(65) COLLATE utf8_persian_ci NOT NULL DEFAULT 0",
                'type' => "INT(11) NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'type' => ['table' => 'phone_type', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],

            ]
        ],
    ],

    'sqlInstall' => [
        "INSERT IGNORE INTO `{prefix}phone_type` (`id`, `label`) VALUES (1 , 'bale');",
        "INSERT IGNORE INTO `{prefix}phone_type` (`id`, `label`) VALUES (2 , 'sms');",
        "INSERT IGNORE INTO `{prefix}phone_type` (`id`, `label`) VALUES (3 , 'whatsApp');",
    ],
];