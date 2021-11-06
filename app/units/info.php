<?php
return [
    'info' => [
        'name' => 'units',
        'description' => 'units',
        'version' => '1.0.0.0',
        'author' => 'Siavash Sepahi',
        'support' => '09379206248',
    ],
    'configuration' => [
    ],
    'db' => [
        'units' => [
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
        "INSERT IGNORE INTO `{prefix}units` (`id`, `label`) VALUES
(null , 'برق'),
(null, 'IT'),
(null, 'توزین خاک'),
(null, 'بالمیل'),
(null, 'اسپری درایر'),
(null, 'سیلو گرانول'),
(null, 'پرس'),
(-4, 'همه'),
(-3, 'مدیران'),
(-1, 'پشتیبانی فنی'),
(-2, 'پشتیبانی IT'),
(null, 'خشک کن');",

    ],
];