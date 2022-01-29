<?php
return [
    'info' => [
        'name' => 'Electrical Substation',
        'description' => 'Monitoring Substation',
        'version' => '1.0.0.0',
        'author' => 'Siavash Sepahi',
        'support' => '09379206248',
    ],
    'configuration' => [
    ],
    'db' => [
        'substation_deviceType' => [
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
        'substation' => [
            'fields' => [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                'label' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'port' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
                'id'
            ],
            'REFERENCES' => [
            ]
        ],
        'Substation_device' => [
            'fields' => [
                'substation_id' => 'INT(11) NOT NULL ',
                'deviceType' => 'INT(11) NOT NULL ',
                'Name' => "varchar(65) COLLATE utf8_persian_ci NOT NULL",
                'unitId' => "INT(11)  NOT NULL",
                'refreshTime' => "INT(11)  NOT NULL",
            ],
            'KEY' => [
            ],
            'PRIMARY KEY' => [
            ],
            'REFERENCES' => [
                'substation_id' => ['table' => 'substation', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
                'deviceType' => ['table' => 'substation_deviceType', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'elecsub_data' => [
            'fields' => [
                'substation_id' => "INT(11) NOT NULL",
                'unitId' => "INT(11) NOT NULL",
                'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'JStart_time' => "varchar(65) COLLATE utf8_persian_ci NULL DEFAULT NULL",
                'Current_A' => 'FLOAT NULL DEFAULT NULL',
                'Current_B' => 'FLOAT NULL DEFAULT NULL',
                'Current_C' => "FLOAT NULL DEFAULT NULL",
                'Current_N' => "FLOAT NULL DEFAULT NULL",
                'Current_G' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Voltage_A_B' => "FLOAT NULL DEFAULT NULL",
                'Voltage_B_C' => "FLOAT NULL DEFAULT NULL",
                'Voltage_C_A' => "FLOAT NULL DEFAULT NULL",
                'Voltage_L_L_Avg' => "FLOAT NULL DEFAULT NULL",
                'Voltage_A_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_B_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_C_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_L_N_Avg' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Reactive_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Apparent_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Power_Factor_A' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_B' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_C' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_Total' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_A' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_B' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_C' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_Total' => "FLOAT NULL DEFAULT NULL",
                'Frequency' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
            ],
            'KEY' => [
                'substation_id',
            ],
            'PRIMARY KEY' => [
            ],
            'REFERENCES' => [
                'substation_id' => ['table' => 'substation', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'elecsub_data_temp' => [
            'fields' => [
                'substation_id' => "INT(11) NOT NULL",
                'unitId' => "INT(11) NOT NULL",
                'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'JStart_time' => "varchar(65) COLLATE utf8_persian_ci NULL DEFAULT NULL",
                'Current_A' => 'FLOAT NULL DEFAULT NULL',
                'Current_B' => 'FLOAT NULL DEFAULT NULL',
                'Current_C' => "FLOAT NULL DEFAULT NULL",
                'Current_N' => "FLOAT NULL DEFAULT NULL",
                'Current_G' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Voltage_A_B' => "FLOAT NULL DEFAULT NULL",
                'Voltage_B_C' => "FLOAT NULL DEFAULT NULL",
                'Voltage_C_A' => "FLOAT NULL DEFAULT NULL",
                'Voltage_L_L_Avg' => "FLOAT NULL DEFAULT NULL",
                'Voltage_A_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_B_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_C_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_L_N_Avg' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Reactive_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Apparent_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Power_Factor_A' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_B' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_C' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_Total' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_A' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_B' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_C' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_Total' => "FLOAT NULL DEFAULT NULL",
                'Frequency' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
            ],
            'KEY' => [
                'substation_id',
            ],
            'PRIMARY KEY' => [
            ],
            'REFERENCES' => [
                'substation_id' => ['table' => 'substation', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'elecsub_data_archive' => [
            'fields' => [
                'substation_id' => "INT(11) NOT NULL",
                'unitId' => "INT(11) NOT NULL",
                'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'JStart_time' => "varchar(65) COLLATE utf8_persian_ci NULL DEFAULT NULL",
                'Current_A' => 'FLOAT NULL DEFAULT NULL',
                'Current_B' => 'FLOAT NULL DEFAULT NULL',
                'Current_C' => "FLOAT NULL DEFAULT NULL",
                'Current_N' => "FLOAT NULL DEFAULT NULL",
                'Current_G' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Voltage_A_B' => "FLOAT NULL DEFAULT NULL",
                'Voltage_B_C' => "FLOAT NULL DEFAULT NULL",
                'Voltage_C_A' => "FLOAT NULL DEFAULT NULL",
                'Voltage_L_L_Avg' => "FLOAT NULL DEFAULT NULL",
                'Voltage_A_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_B_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_C_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_L_N_Avg' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Reactive_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Apparent_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Power_Factor_A' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_B' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_C' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_Total' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_A' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_B' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_C' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_Total' => "FLOAT NULL DEFAULT NULL",
                'Frequency' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
            ],
            'KEY' => [
                'substation_id',
            ],
            'PRIMARY KEY' => [
            ],
            'REFERENCES' => [
                'substation_id' => ['table' => 'substation', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],
        'elecsub_data_merge' => [
            'fields' => [
                'substation_id' => "INT(11) NOT NULL",
                'unitId' => "INT(11) NOT NULL",
                'Start_time' => "datetime NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'JStart_time' => "varchar(65) COLLATE utf8_persian_ci NULL DEFAULT NULL",
                'Current_A' => 'FLOAT NULL DEFAULT NULL',
                'Current_B' => 'FLOAT NULL DEFAULT NULL',
                'Current_C' => "FLOAT NULL DEFAULT NULL",
                'Current_N' => "FLOAT NULL DEFAULT NULL",
                'Current_G' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Current_Avg_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Voltage_A_B' => "FLOAT NULL DEFAULT NULL",
                'Voltage_B_C' => "FLOAT NULL DEFAULT NULL",
                'Voltage_C_A' => "FLOAT NULL DEFAULT NULL",
                'Voltage_L_L_Avg' => "FLOAT NULL DEFAULT NULL",
                'Voltage_A_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_B_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_C_N' => "FLOAT NULL DEFAULT NULL",
                'Voltage_L_N_Avg' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Active_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Reactive_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Apparent_Power_A' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_B' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_C' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Total' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Last_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Present_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Predicted_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_Peak_Demand' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Power_PK_DT_Demand' => "datetime NULL DEFAULT CURRENT_TIMESTAMP",
                'Power_Factor_A' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_B' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_C' => "FLOAT NULL DEFAULT NULL",
                'Power_Factor_Total' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_A' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_B' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_C' => "FLOAT NULL DEFAULT NULL",
                'Displacement_Power_Factor_Total' => "FLOAT NULL DEFAULT NULL",
                'Frequency' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Active_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Reactive_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered_Pos_Received' => "FLOAT NULL DEFAULT NULL",
                'Apparent_Energy_Delivered_Neg_Received' => "FLOAT NULL DEFAULT NULL",
            ],
            'KEY' => [
                'substation_id',
            ],
            'PRIMARY KEY' => [
            ],
            'REFERENCES' => [
                'substation_id' => ['table' => 'substation', 'column' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'CASCADE'],
            ]
        ],

    ],
    'sqlInstall' => [
        "INSERT IGNORE INTO `{prefix}substation_devicetype` (`id`, `label`) VALUES (1, 'Schneider PM2100');",
        "INSERT IGNORE INTO `{prefix}substation_devicetype` (`id`, `label`) VALUES (2, 'Schneider PM2200');",
        "CREATE TRIGGER IF NOT EXISTS `{prefix}elecsub_data_after_insert` AFTER INSERT ON `{prefix}elecsub_data` FOR EACH ROW BEGIN
            INSERT INTO {prefix}elecsub_data_merge(substation_id,unitId,Start_time,JStart_time,Current_A,Current_B,Current_C,Current_N,Current_G,Current_Avg,Voltage_A_B,Voltage_B_C,Voltage_C_A,Voltage_L_L_Avg,Voltage_A_N,Voltage_B_N,Voltage_C_N,Voltage_L_N_Avg,Active_Power_A,Active_Power_B,Active_Power_C,Active_Power_Total,Reactive_Power_A,Reactive_Power_B,Reactive_Power_C,Reactive_Power_Total,Apparent_Power_A,Apparent_Power_B,Apparent_Power_C,Apparent_Power_Total,Power_Factor_A,Power_Factor_B,Power_Factor_C,Power_Factor_Total,Displacement_Power_Factor_A,Displacement_Power_Factor_B,Displacement_Power_Factor_C,Displacement_Power_Factor_Total,Frequency,Active_Energy_Delivered,Active_Energy_Received,Active_Energy_Delivered_Pos_Received,Active_Energy_Delivered_Neg_Received,Reactive_Energy_Delivered,Reactive_Energy_Received,Reactive_Energy_Delivered_Pos_Received,Reactive_Energy_Delivered_Neg_Received,Apparent_Energy_Delivered,Apparent_Energy_Received,Apparent_Energy_Delivered_Pos_Received,Apparent_Energy_Delivered_Neg_Received,Active_Power_Last_Demand,Reactive_Power_Last_Demand,Apparent_Power_Last_Demand,Current_Avg_Last_Demand,Current_Avg_Present_Demand,Current_Avg_Predicted_Demand,Current_Avg_Peak_Demand,Current_Avg_PK_DT_Demand,Active_Power_Present_Demand,Active_Power_Predicted_Demand,Active_Power_Peak_Demand,Active_Power_PK_DT_Demand,Reactive_Power_Present_Demand,Reactive_Power_Predicted_Demand,Reactive_Power_Peak_Demand,Reactive_Power_PK_DT_Demand,Apparent_Power_Present_Demand,Apparent_Power_Predicted_Demand,Apparent_Power_Peak_Demand,Apparent_Power_PK_DT_Demand)
            VALUES(NEW.substation_id,NEW.unitId,NEW.Start_time,NEW.JStart_time,NEW.Current_A,NEW.Current_B,NEW.Current_C,NEW.Current_N,NEW.Current_G,NEW.Current_Avg,NEW.Voltage_A_B,NEW.Voltage_B_C,NEW.Voltage_C_A,NEW.Voltage_L_L_Avg,NEW.Voltage_A_N,NEW.Voltage_B_N,NEW.Voltage_C_N,NEW.Voltage_L_N_Avg,NEW.Active_Power_A,NEW.Active_Power_B,NEW.Active_Power_C,NEW.Active_Power_Total,NEW.Reactive_Power_A,NEW.Reactive_Power_B,NEW.Reactive_Power_C,NEW.Reactive_Power_Total,NEW.Apparent_Power_A,NEW.Apparent_Power_B,NEW.Apparent_Power_C,NEW.Apparent_Power_Total,NEW.Power_Factor_A,NEW.Power_Factor_B,NEW.Power_Factor_C,NEW.Power_Factor_Total,NEW.Displacement_Power_Factor_A,NEW.Displacement_Power_Factor_B,NEW.Displacement_Power_Factor_C,NEW.Displacement_Power_Factor_Total,NEW.Frequency,NEW.Active_Energy_Delivered,NEW.Active_Energy_Received,NEW.Active_Energy_Delivered_Pos_Received,NEW.Active_Energy_Delivered_Neg_Received,NEW.Reactive_Energy_Delivered,NEW.Reactive_Energy_Received,NEW.Reactive_Energy_Delivered_Pos_Received,NEW.Reactive_Energy_Delivered_Neg_Received,NEW.Apparent_Energy_Delivered,NEW.Apparent_Energy_Received,NEW.Apparent_Energy_Delivered_Pos_Received,NEW.Apparent_Energy_Delivered_Neg_Received,NEW.Active_Power_Last_Demand,NEW.Reactive_Power_Last_Demand,NEW.Apparent_Power_Last_Demand,NEW.Current_Avg_Last_Demand,NEW.Current_Avg_Present_Demand,NEW.Current_Avg_Predicted_Demand,NEW.Current_Avg_Peak_Demand,NEW.Current_Avg_PK_DT_Demand,NEW.Active_Power_Present_Demand,NEW.Active_Power_Predicted_Demand,NEW.Active_Power_Peak_Demand,NEW.Active_Power_PK_DT_Demand,NEW.Reactive_Power_Present_Demand,NEW.Reactive_Power_Predicted_Demand,NEW.Reactive_Power_Peak_Demand,NEW.Reactive_Power_PK_DT_Demand,NEW.Apparent_Power_Present_Demand,NEW.Apparent_Power_Predicted_Demand,NEW.Apparent_Power_Peak_Demand,NEW.Apparent_Power_PK_DT_Demand);
            INSERT INTO {prefix}elecsub_data_merge(substation_id,unitId,Start_time,JStart_time,Current_A,Current_B,Current_C,Current_N,Current_G,Current_Avg,Voltage_A_B,Voltage_B_C,Voltage_C_A,Voltage_L_L_Avg,Voltage_A_N,Voltage_B_N,Voltage_C_N,Voltage_L_N_Avg,Active_Power_A,Active_Power_B,Active_Power_C,Active_Power_Total,Reactive_Power_A,Reactive_Power_B,Reactive_Power_C,Reactive_Power_Total,Apparent_Power_A,Apparent_Power_B,Apparent_Power_C,Apparent_Power_Total,Power_Factor_A,Power_Factor_B,Power_Factor_C,Power_Factor_Total,Displacement_Power_Factor_A,Displacement_Power_Factor_B,Displacement_Power_Factor_C,Displacement_Power_Factor_Total,Frequency,Active_Energy_Delivered,Active_Energy_Received,Active_Energy_Delivered_Pos_Received,Active_Energy_Delivered_Neg_Received,Reactive_Energy_Delivered,Reactive_Energy_Received,Reactive_Energy_Delivered_Pos_Received,Reactive_Energy_Delivered_Neg_Received,Apparent_Energy_Delivered,Apparent_Energy_Received,Apparent_Energy_Delivered_Pos_Received,Apparent_Energy_Delivered_Neg_Received,Active_Power_Last_Demand,Reactive_Power_Last_Demand,Apparent_Power_Last_Demand,Current_Avg_Last_Demand,Current_Avg_Present_Demand,Current_Avg_Predicted_Demand,Current_Avg_Peak_Demand,Current_Avg_PK_DT_Demand,Active_Power_Present_Demand,Active_Power_Predicted_Demand,Active_Power_Peak_Demand,Active_Power_PK_DT_Demand,Reactive_Power_Present_Demand,Reactive_Power_Predicted_Demand,Reactive_Power_Peak_Demand,Reactive_Power_PK_DT_Demand,Apparent_Power_Present_Demand,Apparent_Power_Predicted_Demand,Apparent_Power_Peak_Demand,Apparent_Power_PK_DT_Demand)
            VALUES(NEW.substation_id,NEW.unitId,NEW.Start_time,NEW.JStart_time,NEW.Current_A,NEW.Current_B,NEW.Current_C,NEW.Current_N,NEW.Current_G,NEW.Current_Avg,NEW.Voltage_A_B,NEW.Voltage_B_C,NEW.Voltage_C_A,NEW.Voltage_L_L_Avg,NEW.Voltage_A_N,NEW.Voltage_B_N,NEW.Voltage_C_N,NEW.Voltage_L_N_Avg,NEW.Active_Power_A,NEW.Active_Power_B,NEW.Active_Power_C,NEW.Active_Power_Total,NEW.Reactive_Power_A,NEW.Reactive_Power_B,NEW.Reactive_Power_C,NEW.Reactive_Power_Total,NEW.Apparent_Power_A,NEW.Apparent_Power_B,NEW.Apparent_Power_C,NEW.Apparent_Power_Total,NEW.Power_Factor_A,NEW.Power_Factor_B,NEW.Power_Factor_C,NEW.Power_Factor_Total,NEW.Displacement_Power_Factor_A,NEW.Displacement_Power_Factor_B,NEW.Displacement_Power_Factor_C,NEW.Displacement_Power_Factor_Total,NEW.Frequency,NEW.Active_Energy_Delivered,NEW.Active_Energy_Received,NEW.Active_Energy_Delivered_Pos_Received,NEW.Active_Energy_Delivered_Neg_Received,NEW.Reactive_Energy_Delivered,NEW.Reactive_Energy_Received,NEW.Reactive_Energy_Delivered_Pos_Received,NEW.Reactive_Energy_Delivered_Neg_Received,NEW.Apparent_Energy_Delivered,NEW.Apparent_Energy_Received,NEW.Apparent_Energy_Delivered_Pos_Received,NEW.Apparent_Energy_Delivered_Neg_Received,NEW.Active_Power_Last_Demand,NEW.Reactive_Power_Last_Demand,NEW.Apparent_Power_Last_Demand,NEW.Current_Avg_Last_Demand,NEW.Current_Avg_Present_Demand,NEW.Current_Avg_Predicted_Demand,NEW.Current_Avg_Peak_Demand,NEW.Current_Avg_PK_DT_Demand,NEW.Active_Power_Present_Demand,NEW.Active_Power_Predicted_Demand,NEW.Active_Power_Peak_Demand,NEW.Active_Power_PK_DT_Demand,NEW.Reactive_Power_Present_Demand,NEW.Reactive_Power_Predicted_Demand,NEW.Reactive_Power_Peak_Demand,NEW.Reactive_Power_PK_DT_Demand,NEW.Apparent_Power_Present_Demand,NEW.Apparent_Power_Predicted_Demand,NEW.Apparent_Power_Peak_Demand,NEW.Apparent_Power_PK_DT_Demand);
        END",
        "CREATE TRIGGER IF NOT EXISTS `{prefix}elecsub_data_temp_after_insert` AFTER INSERT ON `{prefix}elecsub_data_temp` FOR EACH ROW BEGIN
            INSERT INTO {prefix}elecsub_data_merge(substation_id,unitId,Start_time,JStart_time,Current_A,Current_B,Current_C,Current_N,Current_G,Current_Avg,Voltage_A_B,Voltage_B_C,Voltage_C_A,Voltage_L_L_Avg,Voltage_A_N,Voltage_B_N,Voltage_C_N,Voltage_L_N_Avg,Active_Power_A,Active_Power_B,Active_Power_C,Active_Power_Total,Reactive_Power_A,Reactive_Power_B,Reactive_Power_C,Reactive_Power_Total,Apparent_Power_A,Apparent_Power_B,Apparent_Power_C,Apparent_Power_Total,Power_Factor_A,Power_Factor_B,Power_Factor_C,Power_Factor_Total,Displacement_Power_Factor_A,Displacement_Power_Factor_B,Displacement_Power_Factor_C,Displacement_Power_Factor_Total,Frequency,Active_Energy_Delivered,Active_Energy_Received,Active_Energy_Delivered_Pos_Received,Active_Energy_Delivered_Neg_Received,Reactive_Energy_Delivered,Reactive_Energy_Received,Reactive_Energy_Delivered_Pos_Received,Reactive_Energy_Delivered_Neg_Received,Apparent_Energy_Delivered,Apparent_Energy_Received,Apparent_Energy_Delivered_Pos_Received,Apparent_Energy_Delivered_Neg_Received,Active_Power_Last_Demand,Reactive_Power_Last_Demand,Apparent_Power_Last_Demand,Current_Avg_Last_Demand,Current_Avg_Present_Demand,Current_Avg_Predicted_Demand,Current_Avg_Peak_Demand,Current_Avg_PK_DT_Demand,Active_Power_Present_Demand,Active_Power_Predicted_Demand,Active_Power_Peak_Demand,Active_Power_PK_DT_Demand,Reactive_Power_Present_Demand,Reactive_Power_Predicted_Demand,Reactive_Power_Peak_Demand,Reactive_Power_PK_DT_Demand,Apparent_Power_Present_Demand,Apparent_Power_Predicted_Demand,Apparent_Power_Peak_Demand,Apparent_Power_PK_DT_Demand)
            VALUES(NEW.substation_id,NEW.unitId,NEW.Start_time,NEW.JStart_time,NEW.Current_A,NEW.Current_B,NEW.Current_C,NEW.Current_N,NEW.Current_G,NEW.Current_Avg,NEW.Voltage_A_B,NEW.Voltage_B_C,NEW.Voltage_C_A,NEW.Voltage_L_L_Avg,NEW.Voltage_A_N,NEW.Voltage_B_N,NEW.Voltage_C_N,NEW.Voltage_L_N_Avg,NEW.Active_Power_A,NEW.Active_Power_B,NEW.Active_Power_C,NEW.Active_Power_Total,NEW.Reactive_Power_A,NEW.Reactive_Power_B,NEW.Reactive_Power_C,NEW.Reactive_Power_Total,NEW.Apparent_Power_A,NEW.Apparent_Power_B,NEW.Apparent_Power_C,NEW.Apparent_Power_Total,NEW.Power_Factor_A,NEW.Power_Factor_B,NEW.Power_Factor_C,NEW.Power_Factor_Total,NEW.Displacement_Power_Factor_A,NEW.Displacement_Power_Factor_B,NEW.Displacement_Power_Factor_C,NEW.Displacement_Power_Factor_Total,NEW.Frequency,NEW.Active_Energy_Delivered,NEW.Active_Energy_Received,NEW.Active_Energy_Delivered_Pos_Received,NEW.Active_Energy_Delivered_Neg_Received,NEW.Reactive_Energy_Delivered,NEW.Reactive_Energy_Received,NEW.Reactive_Energy_Delivered_Pos_Received,NEW.Reactive_Energy_Delivered_Neg_Received,NEW.Apparent_Energy_Delivered,NEW.Apparent_Energy_Received,NEW.Apparent_Energy_Delivered_Pos_Received,NEW.Apparent_Energy_Delivered_Neg_Received,NEW.Active_Power_Last_Demand,NEW.Reactive_Power_Last_Demand,NEW.Apparent_Power_Last_Demand,NEW.Current_Avg_Last_Demand,NEW.Current_Avg_Present_Demand,NEW.Current_Avg_Predicted_Demand,NEW.Current_Avg_Peak_Demand,NEW.Current_Avg_PK_DT_Demand,NEW.Active_Power_Present_Demand,NEW.Active_Power_Predicted_Demand,NEW.Active_Power_Peak_Demand,NEW.Active_Power_PK_DT_Demand,NEW.Reactive_Power_Present_Demand,NEW.Reactive_Power_Predicted_Demand,NEW.Reactive_Power_Peak_Demand,NEW.Reactive_Power_PK_DT_Demand,NEW.Apparent_Power_Present_Demand,NEW.Apparent_Power_Predicted_Demand,NEW.Apparent_Power_Peak_Demand,NEW.Apparent_Power_PK_DT_Demand);
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