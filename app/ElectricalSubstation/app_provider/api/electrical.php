<?php

namespace App\ElectricalSubstation\app_provider\api;

use App\api\controller\innerController;
use app\ElectricalSubstation\model\elecsub_data_temp;
use app\ElectricalSubstation\model\Substation;
use paymentCms\component\cache;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class electrical extends innerController
{
    public static function newLog(): array
    {
        $DataArray = json_decode($_POST['DataArray']);
        if (isset($DataArray)) {
            foreach ($DataArray as $index => $_dataSTD) {
                $_data = [
                    "Start_time" => $_dataSTD->Start_time,
                    "substation_id" => $_dataSTD->substation_id,
                    "unitId" => $_dataSTD->unitId,
                    "Current_A" => $_dataSTD->Current_A,
                    "Current_B" => $_dataSTD->Current_B,
                    "Current_C" => $_dataSTD->Current_C,
                    "Current_N" => $_dataSTD->Current_N,
                    "Current_G" => $_dataSTD->Current_G,
                    "Current_Avg" => $_dataSTD->Current_Avg,
                    "Current_Unbalance_A" => $_dataSTD->Current_Unbalance_A,
                    "Current_Unbalance_B" => $_dataSTD->Current_Unbalance_B,
                    "Current_Unbalance_C" => $_dataSTD->Current_Unbalance_C,
                    "Current_Unbalance_Worst" => $_dataSTD->Current_Unbalance_Worst,
                    "Voltage_A_B" => $_dataSTD->Voltage_A_B,
                    "Voltage_B_C" => $_dataSTD->Voltage_B_C,
                    "Voltage_C_A" => $_dataSTD->Voltage_C_A,
                    "Voltage_L_L_Avg" => $_dataSTD->Voltage_L_L_Avg,
                    "Voltage_A_N" => $_dataSTD->Voltage_A_N,
                    "Voltage_B_N" => $_dataSTD->Voltage_B_N,
                    "Voltage_C_N" => $_dataSTD->Voltage_C_N,
                    "Voltage_L_N_Avg" => $_dataSTD->Voltage_L_N_Avg,
                    "Voltage_Unbalance_A_B" => $_dataSTD->Voltage_Unbalance_A_B,
                    "Voltage_Unbalance_B_C" => $_dataSTD->Voltage_Unbalance_B_C,
                    "Voltage_Unbalance_C_A" => $_dataSTD->Voltage_Unbalance_C_A,
                    "Voltage_Unbalance_L_L_Worst" => $_dataSTD->Voltage_Unbalance_L_L_Worst,
                    "Voltage_Unbalance_A_N" => $_dataSTD->Voltage_Unbalance_A_N,
                    "Voltage_Unbalance_B_N" => $_dataSTD->Voltage_Unbalance_B_N,
                    "Voltage_Unbalance_C_N" => $_dataSTD->Voltage_Unbalance_C_N,
                    "Voltage_Unbalance_L_N_Worst" => $_dataSTD->Voltage_Unbalance_L_N_Worst,
                    "Active_Power_A" => $_dataSTD->Active_Power_A,
                    "Active_Power_B" => $_dataSTD->Active_Power_B,
                    "Active_Power_C" => $_dataSTD->Active_Power_C,
                    "Active_Power_Total" => $_dataSTD->Active_Power_Total,
                    "Reactive_Power_A" => $_dataSTD->Reactive_Power_A,
                    "Reactive_Power_B" => $_dataSTD->Reactive_Power_B,
                    "Reactive_Power_C" => $_dataSTD->Reactive_Power_C,
                    "Reactive_Power_Total" => $_dataSTD->Reactive_Power_Total,
                    "Apparent_Power_A" => $_dataSTD->Apparent_Power_A,
                    "Apparent_Power_B" => $_dataSTD->Apparent_Power_B,
                    "Apparent_Power_C" => $_dataSTD->Apparent_Power_C,
                    "Apparent_Power_Total" => $_dataSTD->Apparent_Power_Total,
                    "Power_Factor_A" => $_dataSTD->Power_Factor_A,
                    "Power_Factor_B" => $_dataSTD->Power_Factor_B,
                    "Power_Factor_C" => $_dataSTD->Power_Factor_C,
                    "Power_Factor_Total" => $_dataSTD->Power_Factor_Total,
                    "Displacement_Power_Factor_A" => $_dataSTD->Displacement_Power_Factor_A,
                    "Displacement_Power_Factor_B" => $_dataSTD->Displacement_Power_Factor_B,
                    "Displacement_Power_Factor_C" => $_dataSTD->Displacement_Power_Factor_C,
                    "Displacement_Power_Factor_Total" => $_dataSTD->Displacement_Power_Factor_Total,
                    "Frequency" => $_dataSTD->Frequency,
                    "Active_Energy_Delivered_Into_Load" => $_dataSTD->Active_Energy_Delivered_Into_Load,
                    "Active_Energy_Received_Out_of_Load" => $_dataSTD->Active_Energy_Received_Out_of_Load,
                    "Active_Energy_Delivered_Pos_Received" => $_dataSTD->Active_Energy_Delivered_Pos_Received,
                    "Active_Energy_Delivered_Neg_Received" => $_dataSTD->Active_Energy_Delivered_Neg_Received,
                    "Reactive_Energy_Delivered" => $_dataSTD->Reactive_Energy_Delivered,
                    "Reactive_Energy_Received" => $_dataSTD->Reactive_Energy_Received,
                    "Reactive_Energy_Delivered_Pos_Received" => $_dataSTD->Reactive_Energy_Delivered_Pos_Received,
                    "Reactive_Energy_Delivered_Neg_Received" => $_dataSTD->Reactive_Energy_Delivered_Neg_Received,
                    "Apparent_Energy_Delivered" => $_dataSTD->Apparent_Energy_Delivered,
                    "Apparent_Energy_Received" => $_dataSTD->Apparent_Energy_Received,
                    "Apparent_Energy_Delivered_Pos_Received" => $_dataSTD->Apparent_Energy_Delivered_Pos_Received,
                    "Apparent_Energy_Delivered_Neg_Received" => $_dataSTD->Apparent_Energy_Delivered_Neg_Received,
                    "Reactive_Energy_in_Quadrant_I" => $_dataSTD->Reactive_Energy_in_Quadrant_I,
                    "Reactive_Energy_in_Quadrant_II" => $_dataSTD->Reactive_Energy_in_Quadrant_II,
                    "Reactive_Energy_in_Quadrant_III" => $_dataSTD->Reactive_Energy_in_Quadrant_III,
                    "Reactive_Energy_in_Quadrant_IV" => $_dataSTD->Reactive_Energy_in_Quadrant_IV,
                    "Active_Energy_Delivered_Into_Load_Permanent" => $_dataSTD->Active_Energy_Delivered_Into_Load_Permanent,
                    "Active_Energy_Received_Out_of_Load_Permanent" => $_dataSTD->Active_Energy_Received_Out_of_Load_Permanent,
                    "Active_Energy_Delivered_Pos_Received_Permanent" => $_dataSTD->Active_Energy_Delivered_Pos_Received_Permanent,
                    "Active_Energy_Delivered_Neg_Received_Permanent" => $_dataSTD->Active_Energy_Delivered_Neg_Received_Permanent,
                    "Reactive_Energy_Delivered_Permanent" => $_dataSTD->Reactive_Energy_Delivered_Permanent,
                    "Reactive_Energy_Received_Permanent" => $_dataSTD->Reactive_Energy_Received_Permanent,
                    "Reactive_Energy_Delivered_Pos_Received_Permanent" => $_dataSTD->Reactive_Energy_Delivered_Pos_Received_Permanent,
                    "Reactive_Energy_Delivered_Neg_Received_Permanent" => $_dataSTD->Reactive_Energy_Delivered_Neg_Received_Permanent,
                    "Apparent_Energy_Delivered_Permanent" => $_dataSTD->Apparent_Energy_Delivered_Permanent,
                    "Apparent_Energy_Received_Permanent" => $_dataSTD->Apparent_Energy_Received_Permanent,
                    "Apparent_Energy_Delivered_Pos_Received_Permanent" => $_dataSTD->Apparent_Energy_Delivered_Pos_Received_Permanent,
                    "Apparent_Energy_Delivered_Neg_Received_Permanent" => $_dataSTD->Apparent_Energy_Delivered_Neg_Received_Permanent,
                    "Active_Energy_Delivered_Phase_A" => $_dataSTD->Active_Energy_Delivered_Phase_A,
                    "Active_Energy_Delivered_Phase_B" => $_dataSTD->Active_Energy_Delivered_Phase_B,
                    "Active_Energy_Delivered_Phase_C" => $_dataSTD->Active_Energy_Delivered_Phase_C,
                    "Reactive_Energy_Delivered_Phase_A" => $_dataSTD->Reactive_Energy_Delivered_Phase_A,
                    "Reactive_Energy_Delivered_Phase_B" => $_dataSTD->Reactive_Energy_Delivered_Phase_B,
                    "Reactive_Energy_Delivered_Phase_C" => $_dataSTD->Reactive_Energy_Delivered_Phase_C,
                    "Apparent_Energy_Delivered_Phase_A" => $_dataSTD->Apparent_Energy_Delivered_Phase_A,
                    "Apparent_Energy_Delivered_Phase_B" => $_dataSTD->Apparent_Energy_Delivered_Phase_B,
                    "Apparent_Energy_Delivered_Phase_C" => $_dataSTD->Apparent_Energy_Delivered_Phase_C,
                ];
                $result = self::insertLog($_data);
                if (!$result[0]) {
                    return self::jsonError(['indexOfProblem' => $index, 'error' => $result[1]]);
                }
            }
        } else {
            $result = self::insertLog($_POST);
            if (!$result[0]) {
                return self::jsonError(['indexOfProblem' => 0, 'error' => $result[1]]);
            }
        }


        $data = cache::get('isTileKindUpdate', null, 'ElectricalSubstation');
        $dataSwitch = cache::get('isSwitchKindUpdate', null, 'ElectricalSubstation');
        if ($data !== 'yes' or $dataSwitch !== 'yes') {
            return self::jsonError(null, 205);
        }

        return self::jsonError(null, 204);
    }

    private static function insertLog($_data): array
    {
        $data = request::getFromArray($_data, 'substation_id,unitId,Start_time,Current_A,Current_B,Current_C,Current_N,Current_G,Current_Avg,Current_Unbalance_A,Current_Unbalance_B,Current_Unbalance_C,Current_Unbalance_Worst,Voltage_A_B,Voltage_B_C,Voltage_C_A,Voltage_L_L_Avg,Voltage_A_N,Voltage_B_N,Voltage_C_N,Voltage_L_N_Avg,Voltage_Unbalance_A_B,Voltage_Unbalance_B_C,Voltage_Unbalance_C_A,Voltage_Unbalance_L_L_Worst,Voltage_Unbalance_A_N,Voltage_Unbalance_B_N,Voltage_Unbalance_C_N,Voltage_Unbalance_L_N_Worst,Active_Power_A,Active_Power_B,Active_Power_C,Active_Power_Total,Reactive_Power_A,Reactive_Power_B,Reactive_Power_C,Reactive_Power_Total,Apparent_Power_A,Apparent_Power_B,Apparent_Power_C,Apparent_Power_Total,Power_Factor_A,Power_Factor_B,Power_Factor_C,Power_Factor_Total,Displacement_Power_Factor_A,Displacement_Power_Factor_B,Displacement_Power_Factor_C,Displacement_Power_Factor_Total,Frequency,Active_Energy_Delivered_Into_Load,Active_Energy_Received_Out_of_Load,Active_Energy_Delivered_Pos_Received,Active_Energy_Delivered_Neg_Received,Reactive_Energy_Delivered,Reactive_Energy_Received,Reactive_Energy_Delivered_Pos_Received,Reactive_Energy_Delivered_Neg_Received,Apparent_Energy_Delivered,Apparent_Energy_Received,Apparent_Energy_Delivered_Pos_Received,Apparent_Energy_Delivered_Neg_Received,Reactive_Energy_in_Quadrant_I,Reactive_Energy_in_Quadrant_II,Reactive_Energy_in_Quadrant_III,Reactive_Energy_in_Quadrant_IV,Active_Energy_Delivered_Into_Load_Permanent,Active_Energy_Received_Out_of_Load_Permanent,Active_Energy_Delivered_Pos_Received_Permanent,Active_Energy_Delivered_Neg_Received_Permanent,Reactive_Energy_Delivered_Permanent,Reactive_Energy_Received_Permanent,Reactive_Energy_Delivered_Pos_Received_Permanent,Reactive_Energy_Delivered_Neg_Received_Permanent,Apparent_Energy_Delivered_Permanent,Apparent_Energy_Received_Permanent,Apparent_Energy_Delivered_Pos_Received_Permanent,Apparent_Energy_Delivered_Neg_Received_Permanent,Active_Energy_Delivered_Phase_A,Active_Energy_Delivered_Phase_B,Active_Energy_Delivered_Phase_C,Reactive_Energy_Delivered_Phase_A,Reactive_Energy_Delivered_Phase_B,Reactive_Energy_Delivered_Phase_C,Apparent_Energy_Delivered_Phase_A,Apparent_Energy_Delivered_Phase_B,Apparent_Energy_Delivered_Phase_C');
        /* @var Substation $Substation */
        $Substation = parent::model(['ElectricalSubstation', 'Substation'], [$data['substation_id']], 'id = ? ');

        if ($Substation->getId() != $data['substation_id']) {
            return [false, 'شماره یکتا پست یافت نشد!'];
        }

        /* @var substation_Device $Device */
        $Device = parent::model(['ElectricalSubstation', 'substation_Device'], [$data['unitId']], 'unitId = ? ');

        if ($Device->getUnitId() != $data['unitId']) {
            return [false, 'شماره یکتا دستگاه یافت نشد!'];
        }

        $Time = $data['Start_time'];

        if ($Time == null)
            $Time = date('Y-m-d H:i:s');
        $strTime = strtotime($Time);

        /* @var elecsub_data_temp $log */
        $log = parent::model(['ElectricalSubstation', 'elecsub_data_temp']);

        $log->setStartTime($Time);
        $log->setSubstationId($Substation->getId());
        $log->setUnitId($Device->getUnitId());
        $log->setJStartTime(JDate::jdate('Y/n/j', $strTime));
        $log->setCurrentA($data['Current_A']);
        $log->setCurrentB($data['Current_B']);
        $log->setCurrentC($data['Current_C']);
        $log->setCurrentN($data['Current_N']);
        $log->setCurrentG($data['Current_G']);
        $log->setCurrentAvg($data['Current_Avg']);
        $log->setCurrentUnbalanceA($data['Current_Unbalance_A']);
        $log->setCurrentUnbalanceB($data['Current_Unbalance_B']);
        $log->setCurrentUnbalanceC($data['Current_Unbalance_C']);
        $log->setCurrentUnbalanceWorst($data['Current_Unbalance_Worst']);
        $log->setVoltageAB($data['Voltage_A_B']);
        $log->setVoltageBC($data['Voltage_B_C']);
        $log->setVoltageCA($data['Voltage_C_A']);
        $log->setVoltageLLAvg($data['Voltage_L_L_Avg']);
        $log->setVoltageAN($data['Voltage_A_N']);
        $log->setVoltageBN($data['Voltage_B_N']);
        $log->setVoltageCN($data['Voltage_C_N']);
        $log->setVoltageLNAvg($data['Voltage_L_N_Avg']);
        $log->setVoltageUnbalanceAB($data['Voltage_Unbalance_A_B']);
        $log->setVoltageUnbalanceBC($data['Voltage_Unbalance_B_C']);
        $log->setVoltageUnbalanceCA($data['Voltage_Unbalance_C_A']);
        $log->setVoltageUnbalanceLLWorst($data['Voltage_Unbalance_L_L_Worst']);
        $log->setVoltageUnbalanceAN($data['Voltage_Unbalance_A_N']);
        $log->setVoltageUnbalanceBN($data['Voltage_Unbalance_B_N']);
        $log->setVoltageUnbalanceCN($data['Voltage_Unbalance_C_N']);
        $log->setVoltageUnbalanceLNWorst($data['Voltage_Unbalance_L_N_Worst']);
        $log->setActivePowerA($data['Active_Power_A']);
        $log->setActivePowerB($data['Active_Power_B']);
        $log->setActivePowerC($data['Active_Power_C']);
        $log->setActivePowerTotal($data['Active_Power_Total']);
        $log->setReactivePowerA($data['Reactive_Power_A']);
        $log->setReactivePowerB($data['Reactive_Power_B']);
        $log->setReactivePowerC($data['Reactive_Power_C']);
        $log->setReactivePowerTotal($data['Reactive_Power_Total']);
        $log->setApparentPowerA($data['Apparent_Power_A']);
        $log->setApparentPowerB($data['Apparent_Power_B']);
        $log->setApparentPowerC($data['Apparent_Power_C']);
        $log->setApparentPowerTotal($data['Apparent_Power_Total']);
        $log->setPowerFactorA($data['Power_Factor_A']);
        $log->setPowerFactorB($data['Power_Factor_B']);
        $log->setPowerFactorC($data['Power_Factor_C']);
        $log->setPowerFactorTotal($data['Power_Factor_Total']);
        $log->setDisplacementPowerFactorA($data['Displacement_Power_Factor_A']);
        $log->setDisplacementPowerFactorB($data['Displacement_Power_Factor_B']);
        $log->setDisplacementPowerFactorC($data['Displacement_Power_Factor_C']);
        $log->setDisplacementPowerFactorTotal($data['Displacement_Power_Factor_Total']);
        $log->setFrequency($data['Frequency']);
        $log->setActiveEnergyDeliveredIntoLoad($data['Active_Energy_Delivered_Into_Load']);
        $log->setActiveEnergyReceivedOutOfLoad($data['Active_Energy_Received_Out_of_Load']);
        $log->setActiveEnergyDeliveredPosReceived($data['Active_Energy_Delivered_Pos_Received']);
        $log->setActiveEnergyDeliveredNegReceived($data['Active_Energy_Delivered_Neg_Received']);
        $log->setReactiveEnergyDelivered($data['Reactive_Energy_Delivered']);
        $log->setReactiveEnergyReceived($data['Reactive_Energy_Received']);
        $log->setReactiveEnergyDeliveredPosReceived($data['Reactive_Energy_Delivered_Pos_Received']);
        $log->setReactiveEnergyDeliveredNegReceived($data['Reactive_Energy_Delivered_Neg_Received']);
        $log->setApparentEnergyDelivered($data['Apparent_Energy_Delivered']);
        $log->setApparentEnergyReceived($data['Apparent_Energy_Received']);
        $log->setApparentEnergyDeliveredPosReceived($data['Apparent_Energy_Delivered_Pos_Received']);
        $log->setApparentEnergyDeliveredNegReceived($data['Apparent_Energy_Delivered_Neg_Received']);
        $log->setReactiveEnergyInQuadrantI($data['Reactive_Energy_in_Quadrant_I']);
        $log->setReactiveEnergyInQuadrantII($data['Reactive_Energy_in_Quadrant_II']);
        $log->setReactiveEnergyInQuadrantIII($data['Reactive_Energy_in_Quadrant_III']);
        $log->setReactiveEnergyInQuadrantIV($data['Reactive_Energy_in_Quadrant_IV']);
        $log->setActiveEnergyDeliveredIntoLoadPermanent($data['Active_Energy_Delivered_Into_Load_Permanent']);
        $log->setActiveEnergyReceivedOutOfLoadPermanent($data['Active_Energy_Received_Out_of_Load_Permanent']);
        $log->setActiveEnergyDeliveredPosReceivedPermanent($data['Active_Energy_Delivered_Pos_Received_Permanent']);
        $log->setActiveEnergyDeliveredNegReceivedPermanent($data['Active_Energy_Delivered_Neg_Received_Permanent']);
        $log->setReactiveEnergyDeliveredPermanent($data['Reactive_Energy_Delivered_Permanent']);
        $log->setReactiveEnergyReceivedPermanent($data['Reactive_Energy_Received_Permanent']);
        $log->setReactiveEnergyDeliveredPosReceivedPermanent($data['Reactive_Energy_Delivered_Pos_Received_Permanent']);
        $log->setReactiveEnergyDeliveredNegReceivedPermanent($data['Reactive_Energy_Delivered_Neg_Received_Permanent']);
        $log->setApparentEnergyDeliveredPermanent($data['Apparent_Energy_Delivered_Permanent']);
        $log->setApparentEnergyReceivedPermanent($data['Apparent_Energy_Received_Permanent']);
        $log->setApparentEnergyDeliveredPosReceivedPermanent($data['Apparent_Energy_Delivered_Pos_Received_Permanent']);
        $log->setApparentEnergyDeliveredNegReceivedPermanent($data['Apparent_Energy_Delivered_Neg_Received_Permanent']);
        $log->setActiveEnergyDeliveredPhaseA($data['Active_Energy_Delivered_Phase_A']);
        $log->setActiveEnergyDeliveredPhaseB($data['Active_Energy_Delivered_Phase_B']);
        $log->setActiveEnergyDeliveredPhaseC($data['Active_Energy_Delivered_Phase_C']);
        $log->setReactiveEnergyDeliveredPhaseA($data['Reactive_Energy_Delivered_Phase_A']);
        $log->setReactiveEnergyDeliveredPhaseB($data['Reactive_Energy_Delivered_Phase_B']);
        $log->setReactiveEnergyDeliveredPhaseC($data['Reactive_Energy_Delivered_Phase_C']);
        $log->setApparentEnergyDeliveredPhaseA($data['Apparent_Energy_Delivered_Phase_A']);
        $log->setApparentEnergyDeliveredPhaseB($data['Apparent_Energy_Delivered_Phase_B']);
        $log->setApparentEnergyDeliveredPhaseC($data['Apparent_Energy_Delivered_Phase_C']);
        if (!$log->insertToDataBase()) {
            return [false, model::getLastQuery()];
        }
        return [true];
    }
}


