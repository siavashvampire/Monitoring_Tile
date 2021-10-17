<?php
return [
    'info' => [
        'name' => 'request service',
        'description' => 'system for send request',
        'version' => '1.0.0.0',
        'author' => 'Siavash Sepahi',
        'support' => '09379206248',
        'PLCNeed' => false,
    ],
    'configuration' => [
        'offSensorDescription' => [
            'type' => 'number',
            'status' => '',
            'value' => '',
            'valueDe' =>  null
        ],
    ],
    'db' => [
        'requestService' => [
            'fields' => [
                'requestId' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'requestCode' => "INT(11) NOT NULL",
                'Time_Send' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'JTime_Send' => "date NOT NULL ",
                'Time_Start' => "datetime NOT NULL",
                'Time_End' => "datetime NOT NULL",
                'System_Name' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'phase' => "INT(11) NOT NULL",
                'section' => "INT(11) NOT NULL",
                'Line' => "INT(11) NOT NULL",
                'Cost' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'WorkerSection' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'offTime' => "INT(11) NOT NULL",
                'System_Status' => "INT(11) NOT NULL",
                'WorkTitle' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'BugInfluence' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'latency' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'latencyTime' => "INT(11) NOT NULL",
                'failure' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'failureDes' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'donework' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'doneworkDes' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'unitPerson_id' => "INT(11) NOT NULL",
                'workerPerson_id' => "INT(11) DEFAULT NULL",
                'Sender_note' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'HumanNumber' => "INT(11) NOT NULL DEFAULT 1",
                'Consumable_Parts' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'Consumable_Parts_Qty' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
                'phase',
                'section',
            ],
            'PRIMARY KEY' => [
                'requestId'
            ],
            'REFERENCES' => [
                'phase' => [ 'table' => 'phases' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'section' => [ 'table' => 'sections' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],

            ]
        ],
        'requestService_buginfluence' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => 'varchar(65) COLLATE utf8_persian_ci NOT NULL',

            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'requestService_cost' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => 'varchar(65) COLLATE utf8_persian_ci NOT NULL',

            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'requestService_doneWork' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => 'varchar(65) COLLATE utf8_persian_ci NOT NULL',

            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'requestService_failure' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => 'varchar(65) COLLATE utf8_persian_ci NOT NULL',

            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'requestService_latency' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => 'varchar(65) COLLATE utf8_persian_ci NOT NULL',

            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'requestService_system_status' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => 'varchar(65) COLLATE utf8_persian_ci NOT NULL',

            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'requestService_worktitle' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => 'varchar(65) COLLATE utf8_persian_ci NOT NULL',

            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'consumable_Parts' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'Name' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'unit' => "INT(11) DEFAULT NULL",

            ],
            'KEY' => [
                'unit'
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
                'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
            ]
        ],
    ],
    'sqlInstall' => [
        "INSERT IGNORE INTO `{prefix}requestService_buginfluence` (`id`, `label`) VALUES
(1 , 'افت تولید'),
(2 , 'افت کیفیت'),
(3 , 'سایر');",
        "INSERT IGNORE INTO `{prefix}requestService_cost` (`id`, `label`) VALUES
(1 , 'تست');",
        "INSERT IGNORE INTO `{prefix}requestService_doneWork` (`id`, `label`) VALUES
(1 , 'تنظیم'),
(2 , 'تعمیر'),
(3 , 'تعویض');",
        "INSERT IGNORE INTO `{prefix}requestService_failure` (`id`, `label`) VALUES
(1 , 'عدم روانکاری'),
(2 , 'عدم نظافت'),
(3 , 'شل شدن اتصلات'),
(4 , 'خطای انسانی'),
(5 , 'فرسودگی'),
(6 , 'کاربری غلط'),
(7 , 'استفاده مواد اولیه نامناسب'),
(8 , 'اصلاح ناصحیح در تعمیرات قبلی دستگاه'),
(9 , 'عمل نکردن تجهیزات  محافظتی دستگاه'),
(10 , 'سایر');",
        "INSERT IGNORE INTO `{prefix}requestService_latency` (`id`, `label`) VALUES
(1 , 'عدم ارسال به موقع لیفتراک'),
(2 , 'مدت زمان تامین قطعه از انبار'),
(3 , 'کمبود موجودی قطعه'),
(4 , 'عدم حضور اپراتور در کنار دستگاه'),
(5 , 'مدت زمان تعمیرات لازم توسط تراشکاری و جوشکاری'),
(6 , 'سایر');",
        "INSERT IGNORE INTO `{prefix}requestService_system_status` (`id`, `label`) VALUES
(1 , 'دستگاه در حال تولید'),
(2 , 'تولید با سرعت کم'),
(3 , 'کارکرد دستگاه بدون بار'),
(4 , 'دستگاه متوقف می باشد'),
(5 , 'سایر');",
        "INSERT IGNORE INTO `{prefix}requestService_worktitle` (`id`, `label`) VALUES
(1 , 'تغییر طرح'),
(2 , 'تغییر سایز'),
(3 , 'تعویض دستگاه'),
(4 , 'تعمیرات اصلاحی'),
(5 , 'بازرسی و بررسی مشکلات دستگاه'),
(6 , 'تعمیرات اضطراری'),
(7 , 'تشخیص خرابی'),
(8 , 'تنظیم قطعه');",

    ],
];