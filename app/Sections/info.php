<?php
return [
    'info' => [
        'name' => 'Sections',
        'description' => 'Sections',
        'version' => '1.0.0.0',
        'author' => 'Siavash Sepahi',
        'support' => '09379206248',
        'PLCNeed' => false,
    ],
    'configuration' => [
    ],
    'db' => [
        'sections' => [
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
        "INSERT INTO `{prefix}sections` (`id`, `label`) VALUES
(null , 'برق'),
(null, 'IT'),
(null, 'توزین خاک'),
(null, 'بالمیل'),
(null, 'اسپری درایر'),
(null, 'سیلو گرانول'),
(null, 'پرس'),
(null, 'خشک کن');",

    ],
];