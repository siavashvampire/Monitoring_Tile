<?php
return [
    'info' => [
        'name' => 'DAUnits',
        'description' => 'Monitoring Substation',
        'version' => '1.0.0.0',
        'author' => 'Siavash Sepahi',
        'support' => '09379206248',
        'PLCNeed' => false,
    ],
    'configuration' => [
    ],
    'db' => [
        'DAUnits_Type' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'testPort' => "INT(11) NOT NULL DEFAULT 0",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'DAUnits' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'IP' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'status' => "TINYINT NOT NULL DEFAULT '0'",
                'type' => "INT(11) NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'type' => ['table' => 'DAUnits_Type', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],

            ]
        ],
        'DAUnits_app' => [
            'fields' => [
                'DAUnits_id' => 'INT(11) NOT NULL ',
                'label' => 'varchar(65) COLLATE utf8_persian_ci NOT NULL',
            ],
            'KEY' => [
                'DAUnits_id'
            ],
            'PRIMARY KEY' => [
            ],
            'REFERENCES' => [
                'DAUnits_id' => ['table' => 'DAUnits', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],

            ]
        ],
    ],

    'sqlInstall' => [
        "INSERT IGNORE INTO `{prefix}DAUnits_Type` (`id`, `label`,`testPort`) VALUES (1 , 'PLC_delta_DVP_12SE',0);",
        "INSERT IGNORE INTO `{prefix}DAUnits_Type` (`id`, `label`,`testPort`) VALUES (2 , 'MERSAD_GATEWAY',0);",

    ],
];