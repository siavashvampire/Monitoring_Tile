<?php
return [
	'info' => [
		'name' => 'Mersad Monitoring System',
		'description' => 'Tile Counter',
		'version' => '1.0.0.0',
		'author' => 'Siavash Sepahi',
		'support' => '09379206248',
	],
	'configuration' => [
		'wsPort' => [
			'type' => 'number',
			'status' => '',
			'title' => 'پورت سوکت',
			'description' => '',
			'value' => '4444',
			'valueDe' =>  null
		],
		'WsIP' => [
			'type' => 'textarea',
			'status' => '',
			'title' => 'IP ها سایت',
			'description' => 'هر IP یا دامنه ای که به محیط ادمین و شمارش لحظه ای دسترسی دارد را در هر خط وارد نمایید.',
			'value' => '127.0.0.1',
			'valueDe' =>  null
		],
		'offSensorDescription' => [
			'type' => 'textarea',
			'status' => '',
			'title' => 'مقادیر پیشفرض توضیحات خرابی',
			'description' => 'در هر خط یکی از توضیحات مورد نظر جهت خرابی سنسور را وارد نمایید. در صورتی که خالی باشد، توضیحات خرابی را از سرپرست بخش دریافت می کند.',
			'value' => '',
			'valueDe' =>  null
		],
	],
	'db' => [
        'phases' => [
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
        'phases_budget' => [
            'fields' => [
                'phase_id' => 'INT(11) NOT NULL',
                'StartTime' => "date NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'JStartTime' => "varchar(65) COLLATE utf8_persian_ci  DEFAULT NULL",
                'endTime' => "date NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'JEndTime' => "varchar(65) COLLATE utf8_persian_ci  DEFAULT NULL",
                'budget' => "INT(11) NOT NULL DEFAULT 5000",
                'budgetDiff' => "INT(11) NOT NULL DEFAULT 500",
                'firstDegree' => "INT(11) NOT NULL DEFAULT 100",
                'secondDegree' => "INT(11) NOT NULL DEFAULT 100",
                'thirdDegree' => "INT(11) NOT NULL DEFAULT 100",
                'fourthDegree' => "INT(11) NOT NULL DEFAULT 100",
                'fifthDegree' => "INT(11) NOT NULL DEFAULT 100",
                'firstDegreePer' => "decimal(4,2) NOT NULL DEFAULT 0.00",
                'secondDegreePer' => "decimal(4,2) NOT NULL DEFAULT 0.00",
                'thirdDegreePer' => "decimal(4,2) NOT NULL DEFAULT 0.00",
                'fourthDegreePer' => "decimal(4,2) NOT NULL DEFAULT 0.00",
                'fifthDegreePer' => "decimal(4,2) NOT NULL DEFAULT 0.00",

            ],
            'KEY' => [
                'phase_id',
            ],
            'PRIMARY KEY' => [
            ],
            'REFERENCES' => [
                'phase_id' => [ 'table' => 'phases' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],

            ]
        ],
		'CamSwitch' => [
			'fields' => [
				'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'Switch_plc_id' => "INT(11) NOT NULL",
				'unit' => "INT(11) DEFAULT NULL",
				'phase' => "INT(11) DEFAULT NULL",
				'plc_read' => "TINYINT(1) NOT NULL",
				'RenderCheck' => "TINYINT(1) NOT NULL DEFAULT 0",
				'Active' => "TINYINT(1) NOT NULL ",
				'DelayTime' => "INT(11) NOT NULL DEFAULT 0",
				'IgnoreSensor' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
			],
			'KEY' => [
                'unit',
                'phase',

			],
			'PRIMARY KEY' => [
				'id'
			],
			'REFERENCES' => [
                'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'phase' => [ 'table' => 'phases' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],

            ]
		],
		'sensors' => [
			'fields' => [
				'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'showSort' => 'INT(11) NOT NULL ',
				'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'Sensor_plc_id' => "INT(11) DEFAULT NULL",
				'tile_id' => "int(11) DEFAULT NULL",
				'tile_Count' => "int(11) NOT NULL DEFAULT 1",
                'tileDegree' => "varchar(65) COLLATE utf8_persian_ci  DEFAULT 'همه'",
                'unit' => "int(11) DEFAULT NULL",
                'phase' => "int(11) NOT NULL",
                'plc_read' => "	TINYINT(1) NOT NULL DEFAULT 0",
                'OffTime' => "int(11) NOT NULL DEFAULT '5'",
                'OffTime_Bale' => "int(11) NOT NULL DEFAULT '5'",
                'OffTime_SMS' => "int(11) NOT NULL DEFAULT '5'",
                'Active' => "TINYINT(1) NOT NULL DEFAULT 0",
                'Export' => "TINYINT(4) NOT NULL DEFAULT 1",
                'SensorChosenId' => "varchar(65) COLLATE utf8_persian_ci DEFAULT NULL",
                'SensorSign' => "varchar(65) COLLATE utf8_persian_ci DEFAULT NULL",
                'isVirtual' => "TINYINT(4) NOT NULL DEFAULT 0",
                'isStorage' => "TINYINT(4) NOT NULL DEFAULT 0",
			],
			'KEY' => [
				'tile_id',
				'unit',
                'phase'
			],
			'PRIMARY KEY' => [
				'id'
			],
			'REFERENCES' => [
				'tile_id' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'phase' => [ 'table' => 'phases' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
			]
		],
		'data' => [
			'fields' => [
				'Sensor_id' => "INT(11) NOT NULL",
				'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'JStart_time' => "varchar(65) COLLATE utf8_persian_ci  DEFAULT NULL",
				'AbsTime' => "INT(11) NOT NULL DEFAULT '0'",
				'counter' => "INT(11) NOT NULL DEFAULT '0'",
				'Shift_id' => "int(11) DEFAULT NULL",
				'Shift_group_id' => "int(11) DEFAULT NULL",
				'employers_id' => "int(11) DEFAULT NULL",
				'Tile_Kind' => "int(11) DEFAULT NULL",
				'Motor_Speed' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'phase' => "VARCHAR(10) NULL DEFAULT NULL",
				'tileDegree' => "VARCHAR(10) NULL DEFAULT NULL",
				'unit' => "int(11) DEFAULT NULL",
			],
			'KEY' => [
				'Sensor_id',
				'Tile_Kind',
				'employers_id',
                'shift_id',
				'unit'
			],
			'PRIMARY KEY' => [
			],
			'REFERENCES' => [
                'Sensor_id' => [ 'table' => 'sensors' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
			]
		],
		'data_archive' => [
			'fields' => [
				'Sensor_id' => "INT(11) NOT NULL",
				'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'JStart_time' => "varchar(65) COLLATE utf8_persian_ci  DEFAULT NULL",
				'AbsTime' => "INT(11) NOT NULL DEFAULT '0'",
				'counter' => "INT(11) NOT NULL DEFAULT '0'",
				'Shift_id' => "int(11) DEFAULT NULL",
				'Shift_group_id' => "int(11) DEFAULT NULL",
				'employers_id' => "int(11) DEFAULT NULL",
				'Tile_Kind' => "int(11) DEFAULT NULL",
				'Motor_Speed' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'phase' => "VARCHAR(10) NULL DEFAULT NULL",
				'tileDegree' => "VARCHAR(10) NULL DEFAULT NULL",
				'unit' => "int(11) DEFAULT NULL",
			],
			'KEY' => [
				'Sensor_id',
				'Tile_Kind',
				'employers_id',
                'shift_id',
				'unit'
			],
			'PRIMARY KEY' => [
			],
			'REFERENCES' => [
                'Sensor_id' => [ 'table' => 'sensors' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
			]
		],
		'data_merge' => [
			'fields' => [
				'Sensor_id' => "INT(11) NOT NULL",
				'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'JStart_time' => "varchar(65) COLLATE utf8_persian_ci  DEFAULT NULL",
				'AbsTime' => "INT(11) NOT NULL DEFAULT '0'",
				'counter' => "INT(11) NOT NULL DEFAULT '0'",
				'Shift_id' => "int(11) DEFAULT NULL",
				'Shift_group_id' => "int(11) DEFAULT NULL",
				'employers_id' => "int(11) DEFAULT NULL",
				'Tile_Kind' => "int(11) DEFAULT NULL",
				'Motor_Speed' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'phase' => "VARCHAR(10) NULL DEFAULT NULL",
				'tileDegree' => "VARCHAR(10) NULL DEFAULT NULL",
				'unit' => "int(11) DEFAULT NULL",
			],
			'KEY' => [
				'Sensor_id',
				'Tile_Kind',
				'employers_id',
                'shift_id',
				'unit'
			],
			'PRIMARY KEY' => [
			],
			'REFERENCES' => [
                'Sensor_id' => [ 'table' => 'sensors' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
			]
		],
		'data_merge_hour' => [
			'fields' => [
				'Sensor_id' => "INT(11) NOT NULL",
				'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'JStart_time' => "varchar(65) COLLATE utf8_persian_ci  DEFAULT NULL",
				'AbsTime' => "INT(11) NOT NULL DEFAULT '0'",
				'counter' => "INT(11) NOT NULL DEFAULT '0'",
				'Shift_id' => "int(11) DEFAULT NULL",
				'Shift_group_id' => "int(11) DEFAULT NULL",
				'employers_id' => "int(11) DEFAULT NULL",
				'Tile_Kind' => "int(11) DEFAULT NULL",
				'Motor_Speed' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'phase' => "VARCHAR(10) NULL DEFAULT NULL",
				'tileDegree' => "VARCHAR(10) NULL DEFAULT NULL",
				'unit' => "int(11) DEFAULT NULL",
			],
			'KEY' => [
				'Sensor_id',
				'Tile_Kind',
				'employers_id',
                'shift_id',
				'unit'
			],
			'PRIMARY KEY' => [
			],
			'REFERENCES' => [
                'Sensor_id' => [ 'table' => 'sensors' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
			]
		],
		'data_temp' => [
			'fields' => [
				'Sensor_id' => "INT(11) NOT NULL",
				'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'JStart_time' => "varchar(65) COLLATE utf8_persian_ci  DEFAULT NULL",
				'AbsTime' => "INT(11) NOT NULL DEFAULT '0'",
				'counter' => "INT(11) NOT NULL DEFAULT '0'",
				'Shift_id' => "int(11) DEFAULT NULL",
				'Shift_group_id' => "int(11) DEFAULT NULL",
				'employers_id' => "int(11) DEFAULT NULL",
				'Tile_Kind' => "int(11) DEFAULT NULL",
				'Motor_Speed' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'phase' => "VARCHAR(10) NULL DEFAULT NULL",
				'tileDegree' => "VARCHAR(10) NULL DEFAULT NULL",
				'unit' => "int(11) DEFAULT NULL",
			],
			'KEY' => [
				'Sensor_id',
				'Tile_Kind',
				'employers_id',
                'shift_id',
				'unit'
			],
			'PRIMARY KEY' => [
			],
			'REFERENCES' => [
                'Sensor_id' => [ 'table' => 'sensors' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
			]
		],
        'sensor_active_log' => [
			'fields' => [
				'ActivityId' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'Sensor_id' => "INT(11) NOT NULL",
				'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'JStart_time' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'End_Time' => "datetime DEFAULT NULL",
				'JEnd_Time' => "varchar(65) COLLATE utf8_persian_ci DEFAULT NULL",
				'Start_shift_id' => "int(11) DEFAULT NULL",
				'Start_Shift_group_id' => "int(11) DEFAULT NULL",
				'Start_employers_id' => "int(11) DEFAULT NULL",
				'Start_Tile_Kind' => "int(11) DEFAULT NULL",
                'End_Shift_id' => "int(11) DEFAULT NULL",
				'End_Shift_group_id' => "int(11) DEFAULT NULL",
				'End_employers_id' => "int(11) DEFAULT NULL",
				'End_Tile_Kind' => "int(11) DEFAULT NULL",
				'phase' => "INT(11) DEFAULT NULL",
				'tileDegree' => "VARCHAR(10) NULL DEFAULT 'همه'",
				'unit' => "int(11) DEFAULT NULL",
			],
			'KEY' => [
				'Sensor_id',
				'Start_Tile_Kind',
				'Start_employers_id',
                'Start_shift_id',
				'End_Tile_Kind',
				'End_employers_id',
                'End_shift_id',
				'unit',
                'phase'
			],
			'PRIMARY KEY' => [
                'ActivityId'
			],
			'REFERENCES' => [
				'Start_employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Sensor_id' => [ 'table' => 'sensors' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Start_Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Start_Shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'End_employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'End_Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'End_Shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'phase' => [ 'table' => 'phases' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
            ]
		],
        'sensor_active_log_archive' => [
			'fields' => [
				'ActivityId' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'Sensor_id' => "INT(11) NOT NULL",
				'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'JStart_time' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'End_Time' => "datetime DEFAULT NULL",
				'JEnd_Time' => "varchar(65) COLLATE utf8_persian_ci DEFAULT NULL",
				'Start_shift_id' => "int(11) DEFAULT NULL",
				'Start_Shift_group_id' => "int(11) DEFAULT NULL",
				'Start_employers_id' => "int(11) DEFAULT NULL",
				'Start_Tile_Kind' => "int(11) DEFAULT NULL",
                'End_Shift_id' => "int(11) DEFAULT NULL",
				'End_Shift_group_id' => "int(11) DEFAULT NULL",
				'End_employers_id' => "int(11) DEFAULT NULL",
				'End_Tile_Kind' => "int(11) DEFAULT NULL",
				'phase' => "INT(11) DEFAULT NULL",
				'tileDegree' => "VARCHAR(10) NULL DEFAULT 'همه' ",
				'unit' => "int(11) DEFAULT NULL",
				'reason' => "TEXT COLLATE utf8_persian_ci NULL DEFAULT NULL",
				'reasonType' => "TEXT COLLATE utf8_persian_ci NULL DEFAULT NULL",
				'description' => "TEXT COLLATE utf8_persian_ci NULL DEFAULT NULL",
				'infoInsert' => "int(11) DEFAULT NULL",
			],
			'KEY' => [
				'Sensor_id',
				'Start_Tile_Kind',
				'Start_employers_id',
                'Start_shift_id',
				'End_Tile_Kind',
				'End_employers_id',
                'End_shift_id',
				'unit',
				'infoInsert',
                'phase'
			],
			'PRIMARY KEY' => [
                'ActivityId'
			],
			'REFERENCES' => [
				'Start_employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Sensor_id' => [ 'table' => 'sensors' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Start_Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Start_Shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'End_employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'End_Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'End_Shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'infoInsert' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'phase' => [ 'table' => 'phases' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
            ]
		],
        'sensor_active_log_merge' => [
			'fields' => [
				'ActivityId' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'Sensor_id' => "INT(11) NOT NULL",
				'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'JStart_time' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'End_Time' => "datetime DEFAULT NULL",
				'JEnd_Time' => "varchar(65) COLLATE utf8_persian_ci DEFAULT NULL",
				'DiffTimeSec' => "INT(20) NOT NULL DEFAULT 0 ",
				'Start_shift_id' => "int(11) DEFAULT NULL",
				'Start_Shift_group_id' => "int(11) DEFAULT NULL",
				'Start_employers_id' => "int(11) DEFAULT NULL",
				'Start_Tile_Kind' => "int(11) DEFAULT NULL",
                'End_Shift_id' => "int(11) DEFAULT NULL",
				'End_Shift_group_id' => "int(11) DEFAULT NULL",
				'End_employers_id' => "int(11) DEFAULT NULL",
				'End_Tile_Kind' => "int(11) DEFAULT NULL",
				'phase' => "INT(11) DEFAULT NULL",
				'tileDegree' => "VARCHAR(10) NOT NULL DEFAULT 'همه' ",
				'unit' => "int(11) DEFAULT NULL",
			],
			'KEY' => [
				'Sensor_id',
				'Start_Tile_Kind',
				'Start_employers_id',
                'Start_shift_id',
				'End_Tile_Kind',
				'End_employers_id',
                'End_shift_id',
				'unit',
                'phase'
			],
			'PRIMARY KEY' => [
                'ActivityId'
			],
			'REFERENCES' => [
				'Start_employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Sensor_id' => [ 'table' => 'sensors' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Start_Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Start_Shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'End_employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'End_Tile_Kind' => [ 'table' => 'tile_kind' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'End_Shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'phase' => [ 'table' => 'phases' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
            ]
		],
        'switch_active_log' => [
			'fields' => [
				'ActivityId' => 'INT(11) NOT NULL',
				'Sensor_id' => "INT(11) NOT NULL",
				'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'JStart_time' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'End_Time' => "datetime DEFAULT NULL",
				'JEnd_Time' => "varchar(65) COLLATE utf8_persian_ci DEFAULT NULL",
				'Start_shift_id' => "int(11) DEFAULT NULL",
				'Start_Shift_group_id' => "int(11) DEFAULT NULL",
				'Start_employers_id' => "int(11) DEFAULT NULL",
                'End_Shift_id' => "int(11) DEFAULT NULL",
				'End_Shift_group_id' => "int(11) DEFAULT NULL",
				'End_employers_id' => "int(11) DEFAULT NULL",
				'phase' => "INT(11) DEFAULT NULL",
				'unit' => "int(11) DEFAULT NULL",
			],
			'KEY' => [
				'Sensor_id',
				'Start_employers_id',
                'Start_shift_id',
				'End_employers_id',
                'End_shift_id',
				'unit',
                'phase'
			],
			'PRIMARY KEY' => [
			],
			'REFERENCES' => [
				'Start_employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Sensor_id' => [ 'table' => 'sensors' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Start_Shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'End_employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'End_Shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'phase' => [ 'table' => 'phases' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
            ]
		],
        'switch_active_log_archive' => [
			'fields' => [
				'ActivityId' => 'INT(11) NOT NULL',
				'Sensor_id' => "INT(11) NOT NULL",
				'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
				'JStart_time' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'End_Time' => "datetime DEFAULT NULL",
				'JEnd_Time' => "varchar(65) COLLATE utf8_persian_ci DEFAULT NULL",
				'Start_shift_id' => "int(11) DEFAULT NULL",
				'Start_Shift_group_id' => "int(11) DEFAULT NULL",
				'Start_employers_id' => "int(11) DEFAULT NULL",
                'End_Shift_id' => "int(11) DEFAULT NULL",
				'End_Shift_group_id' => "int(11) DEFAULT NULL",
				'End_employers_id' => "int(11) DEFAULT NULL",
				'phase' => "INT(11) DEFAULT NULL",
				'unit' => "int(11) DEFAULT NULL",
                'reason' => "TEXT COLLATE utf8_persian_ci NULL DEFAULT NULL",
                'description' => "TEXT COLLATE utf8_persian_ci NULL DEFAULT NULL",
                'infoInsert' => "int(11) DEFAULT NULL",			],
			'KEY' => [
				'Sensor_id',
				'Start_employers_id',
                'Start_shift_id',
				'End_employers_id',
                'End_shift_id',
				'unit',
                'phase',
                'infoInsert'
			],
			'PRIMARY KEY' => [
			],
			'REFERENCES' => [
				'Start_employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Sensor_id' => [ 'table' => 'sensors' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'Start_Shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'End_employers_id' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'End_Shift_id' => [ 'table' => 'shift_work' , 'column' => 'shift_id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
				'unit' => [ 'table' => 'units' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'phase' => [ 'table' => 'phases' , 'column' => 'id' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
                'infoInsert' => [ 'table' => 'user' , 'column' => 'userId' , 'on_delete' => 'RESTRICT' , 'on_update' => 'CASCADE' ],
            ]
		],
		'diagrams' => [
			'fields' => [
				'diagramId' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'name' => "varchar(255) COLLATE utf8_persian_ci NOT NULL",
				'pictureName' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'diagram' => "varchar(10000) COLLATE utf8_persian_ci NOT NULL",
			],
			'KEY' => [
			],
			'PRIMARY KEY' => [
				'diagramId'
			],
			'REFERENCES' => [
			]
		],
		'off_sensor_reasons' => [
			'fields' => [
				'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
				'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
				'parentId' => "int(11) DEFAULT NULL",
			],
			'KEY' => [
				'parentId'
			],
			'PRIMARY KEY' => [
				'id'
			],
			'REFERENCES' => [
				'parentId' => [ 'table' => 'off_sensor_reasons' , 'column' => 'id' , 'on_delete' => 'CASCADE' , 'on_update' => 'CASCADE' ],
			]
		],
		'reasonType' => [
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
        "INSERT IGNORE INTO `{prefix}phases` (`id`, `label`) VALUES (-4, 'همه');",
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