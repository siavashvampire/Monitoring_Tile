<?php
return [
    'info' => [
        'name' => 'shiftWork',
        'description' => 'shiftWork',
        'version' => '1.0.0.0',
        'author' => 'Siavash Sepahi',
        'support' => '09379206248',
        'PLCNeed' => false,
    ],
    'configuration' => [
    ],
    'db' => [
        'shift_work' => [
            'fields' => [
                'shift_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'shift_name' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'taskmaster_id' => "INT(11) NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'shift_id'
            ],
            'REFERENCES' => [
                'taskmaster_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
            ]
        ],
        'shift_time' => [
            'fields' => [
                'shift_id' => 'INT(11) NOT NULL',
                'onDay' => "varchar(12) COLLATE utf8_persian_ci NOT NULL",
                'startTime' => "TIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'endTime' => "TIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'shift_time_group' => "INT(11) NOT NULL",
            ],
            'KEY' => [
                'shift_time_group'
            ],
            'PRIMARY KEY' => [
            ],
            'REFERENCES' => [
                'shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ]
            ]
        ],
    ],

    'sqlInstall' => [
        "INSERT IGNORE INTO `{prefix}shift_work`(`shift_id`, `shift_name`, `taskmaster_id`) VALUES  (-1 , 'ذخیره ساز' , -1);",
    ],
];