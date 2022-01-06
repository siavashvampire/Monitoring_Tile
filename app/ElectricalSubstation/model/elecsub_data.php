<?php

namespace App\ElectricalSubstation\model;

use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class elecsub_data extends model implements modelInterFace
{
    private $primaryKey = null;
    private $primaryKeyShouldNotInsertOrUpdate = null;

    private $substation_id;
    private $unitId;
    private $Start_time;
    private $JStart_time;
    private $Current_A;
    private $Current_B;
    private $Current_C;
    private $Current_N;
    private $Current_G;
    private $Current_Avg;
    private $Current_Unbalance_A;
    private $Current_Unbalance_B;
    private $Current_Unbalance_C;
    private $Current_Unbalance_Worst;
    private $Voltage_A_B;
    private $Voltage_B_C;
    private $Voltage_C_A;
    private $Voltage_L_L_Avg;
    private $Voltage_A_N;
    private $Voltage_B_N;
    private $Voltage_C_N;
    private $Voltage_L_N_Avg;
    private $Voltage_Unbalance_A_B;
    private $Voltage_Unbalance_B_C;
    private $Voltage_Unbalance_C_A;
    private $Voltage_Unbalance_L_L_Worst;
    private $Voltage_Unbalance_A_N;
    private $Voltage_Unbalance_B_N;
    private $Voltage_Unbalance_C_N;
    private $Voltage_Unbalance_L_N_Worst;
    private $Active_Power_A;
    private $Active_Power_B;
    private $Active_Power_C;
    private $Active_Power_Total;
    private $Reactive_Power_A;
    private $Reactive_Power_B;
    private $Reactive_Power_C;
    private $Reactive_Power_Total;
    private $Apparent_Power_A;
    private $Apparent_Power_B;
    private $Apparent_Power_C;
    private $Apparent_Power_Total;
    private $Power_Factor_A;
    private $Power_Factor_B;
    private $Power_Factor_C;
    private $Power_Factor_Total;
    private $Displacement_Power_Factor_A;
    private $Displacement_Power_Factor_B;
    private $Displacement_Power_Factor_C;
    private $Displacement_Power_Factor_Total;
    private $Frequency;
    private $Active_Energy_Delivered_Into_Load;
    private $Active_Energy_Received_Out_of_Load;
    private $Active_Energy_Delivered_Pos_Received;
    private $Active_Energy_Delivered_Neg_Received;
    private $Reactive_Energy_Delivered;
    private $Reactive_Energy_Received;
    private $Reactive_Energy_Delivered_Pos_Received;
    private $Reactive_Energy_Delivered_Neg_Received;
    private $Apparent_Energy_Delivered;
    private $Apparent_Energy_Received;
    private $Apparent_Energy_Delivered_Pos_Received;
    private $Apparent_Energy_Delivered_Neg_Received;
    private $Reactive_Energy_in_Quadrant_I;
    private $Reactive_Energy_in_Quadrant_II;
    private $Reactive_Energy_in_Quadrant_III;
    private $Reactive_Energy_in_Quadrant_IV;
    private $Active_Energy_Delivered_Into_Load_Permanent;
    private $Active_Energy_Received_Out_of_Load_Permanent;
    private $Active_Energy_Delivered_Pos_Received_Permanent;
    private $Active_Energy_Delivered_Neg_Received_Permanent;
    private $Reactive_Energy_Delivered_Permanent;
    private $Reactive_Energy_Received_Permanent;
    private $Reactive_Energy_Delivered_Pos_Received_Permanent;
    private $Reactive_Energy_Delivered_Neg_Received_Permanent;
    private $Apparent_Energy_Delivered_Permanent;
    private $Apparent_Energy_Received_Permanent;
    private $Apparent_Energy_Delivered_Pos_Received_Permanent;
    private $Apparent_Energy_Delivered_Neg_Received_Permanent;
    private $Active_Energy_Delivered_Phase_A;
    private $Active_Energy_Delivered_Phase_B;
    private $Active_Energy_Delivered_Phase_C;
    private $Reactive_Energy_Delivered_Phase_A;
    private $Reactive_Energy_Delivered_Phase_B;
    private $Reactive_Energy_Delivered_Phase_C;
    private $Apparent_Energy_Delivered_Phase_A;
    private $Apparent_Energy_Delivered_Phase_B;
    private $Apparent_Energy_Delivered_Phase_C;


    public function setFromArray($result)
    {
        $this->substation_id = $result['substation_id'];
        $this->unitId = $result['unitId'];
        $this->Start_time = $result['Start_time'];
        $this->JStart_time = $result['JStart_time'];
        $this->Current_A = $result['Current_A'];
        $this->Current_B = $result['Current_B'];
        $this->Current_C = $result['Current_C'];
        $this->Current_N = $result['Current_N'];
        $this->Current_G = $result['Current_G'];
        $this->Current_Avg = $result['Current_Avg'];
        $this->Current_Unbalance_A = $result['Current_Unbalance_A'];
        $this->Current_Unbalance_B = $result['Current_Unbalance_B'];
        $this->Current_Unbalance_C = $result['Current_Unbalance_C'];
        $this->Current_Unbalance_Worst = $result['Current_Unbalance_Worst'];
        $this->Voltage_A_B = $result['Voltage_A_B'];
        $this->Voltage_B_C = $result['Voltage_B_C'];
        $this->Voltage_C_A = $result['Voltage_C_A'];
        $this->Voltage_L_L_Avg = $result['Voltage_L_L_Avg'];
        $this->Voltage_A_N = $result['Voltage_A_N'];
        $this->Voltage_B_N = $result['Voltage_B_N'];
        $this->Voltage_C_N = $result['Voltage_C_N'];
        $this->Voltage_L_N_Avg = $result['Voltage_L_N_Avg'];
        $this->Voltage_Unbalance_A_B = $result['Voltage_Unbalance_A_B'];
        $this->Voltage_Unbalance_B_C = $result['Voltage_Unbalance_B_C'];
        $this->Voltage_Unbalance_C_A = $result['Voltage_Unbalance_C_A'];
        $this->Voltage_Unbalance_L_L_Worst = $result['Voltage_Unbalance_L_L_Worst'];
        $this->Voltage_Unbalance_A_N = $result['Voltage_Unbalance_A_N'];
        $this->Voltage_Unbalance_B_N = $result['Voltage_Unbalance_B_N'];
        $this->Voltage_Unbalance_C_N = $result['Voltage_Unbalance_C_N'];
        $this->Voltage_Unbalance_L_N_Worst = $result['Voltage_Unbalance_L_N_Worst'];
        $this->Active_Power_A = $result['Active_Power_A'];
        $this->Active_Power_B = $result['Active_Power_B'];
        $this->Active_Power_C = $result['Active_Power_C'];
        $this->Active_Power_Total = $result['Active_Power_Total'];
        $this->Reactive_Power_A = $result['Reactive_Power_A'];
        $this->Reactive_Power_B = $result['Reactive_Power_B'];
        $this->Reactive_Power_C = $result['Reactive_Power_C'];
        $this->Reactive_Power_Total = $result['Reactive_Power_Total'];
        $this->Apparent_Power_A = $result['Apparent_Power_A'];
        $this->Apparent_Power_B = $result['Apparent_Power_B'];
        $this->Apparent_Power_C = $result['Apparent_Power_C'];
        $this->Apparent_Power_Total = $result['Apparent_Power_Total'];
        $this->Power_Factor_A = $result['Power_Factor_A'];
        $this->Power_Factor_B = $result['Power_Factor_B'];
        $this->Power_Factor_C = $result['Power_Factor_C'];
        $this->Power_Factor_Total = $result['Power_Factor_Total'];
        $this->Displacement_Power_Factor_A = $result['Displacement_Power_Factor_A'];
        $this->Displacement_Power_Factor_B = $result['Displacement_Power_Factor_B'];
        $this->Displacement_Power_Factor_C = $result['Displacement_Power_Factor_C'];
        $this->Displacement_Power_Factor_Total = $result['Displacement_Power_Factor_Total'];
        $this->Frequency = $result['Frequency'];
        $this->Active_Energy_Delivered_Into_Load = $result['Active_Energy_Delivered_Into_Load'];
        $this->Active_Energy_Received_Out_of_Load = $result['Active_Energy_Received_Out_of_Load'];
        $this->Active_Energy_Delivered_Pos_Received = $result['Active_Energy_Delivered_Pos_Received'];
        $this->Active_Energy_Delivered_Neg_Received = $result['Active_Energy_Delivered_Neg_Received'];
        $this->Reactive_Energy_Delivered = $result['Reactive_Energy_Delivered'];
        $this->Reactive_Energy_Received = $result['Reactive_Energy_Received'];
        $this->Reactive_Energy_Delivered_Pos_Received = $result['Reactive_Energy_Delivered_Pos_Received'];
        $this->Reactive_Energy_Delivered_Neg_Received = $result['Reactive_Energy_Delivered_Neg_Received'];
        $this->Apparent_Energy_Delivered = $result['Apparent_Energy_Delivered'];
        $this->Apparent_Energy_Received = $result['Apparent_Energy_Received'];
        $this->Apparent_Energy_Delivered_Pos_Received = $result['Apparent_Energy_Delivered_Pos_Received'];
        $this->Apparent_Energy_Delivered_Neg_Received = $result['Apparent_Energy_Delivered_Neg_Received'];
        $this->Reactive_Energy_in_Quadrant_I = $result['Reactive_Energy_in_Quadrant_I'];
        $this->Reactive_Energy_in_Quadrant_II = $result['Reactive_Energy_in_Quadrant_II'];
        $this->Reactive_Energy_in_Quadrant_III = $result['Reactive_Energy_in_Quadrant_III'];
        $this->Reactive_Energy_in_Quadrant_IV = $result['Reactive_Energy_in_Quadrant_IV'];
        $this->Active_Energy_Delivered_Into_Load_Permanent = $result['Active_Energy_Delivered_Into_Load_Permanent'];
        $this->Active_Energy_Received_Out_of_Load_Permanent = $result['Active_Energy_Received_Out_of_Load_Permanent'];
        $this->Active_Energy_Delivered_Pos_Received_Permanent = $result['Active_Energy_Delivered_Pos_Received_Permanent'];
        $this->Active_Energy_Delivered_Neg_Received_Permanent = $result['Active_Energy_Delivered_Neg_Received_Permanent'];
        $this->Reactive_Energy_Delivered_Permanent = $result['Reactive_Energy_Delivered_Permanent'];
        $this->Reactive_Energy_Received_Permanent = $result['Reactive_Energy_Received_Permanent'];
        $this->Reactive_Energy_Delivered_Pos_Received_Permanent = $result['Reactive_Energy_Delivered_Pos_Received_Permanent'];
        $this->Reactive_Energy_Delivered_Neg_Received_Permanent = $result['Reactive_Energy_Delivered_Neg_Received_Permanent'];
        $this->Apparent_Energy_Delivered_Permanent = $result['Apparent_Energy_Delivered_Permanent'];
        $this->Apparent_Energy_Received_Permanent = $result['Apparent_Energy_Received_Permanent'];
        $this->Apparent_Energy_Delivered_Pos_Received_Permanent = $result['Apparent_Energy_Delivered_Pos_Received_Permanent'];
        $this->Apparent_Energy_Delivered_Neg_Received_Permanent = $result['Apparent_Energy_Delivered_Neg_Received_Permanent'];
        $this->Active_Energy_Delivered_Phase_A = $result['Active_Energy_Delivered_Phase_A'];
        $this->Active_Energy_Delivered_Phase_B = $result['Active_Energy_Delivered_Phase_B'];
        $this->Active_Energy_Delivered_Phase_C = $result['Active_Energy_Delivered_Phase_C'];
        $this->Reactive_Energy_Delivered_Phase_A = $result['Reactive_Energy_Delivered_Phase_A'];
        $this->Reactive_Energy_Delivered_Phase_B = $result['Reactive_Energy_Delivered_Phase_B'];
        $this->Reactive_Energy_Delivered_Phase_C = $result['Reactive_Energy_Delivered_Phase_C'];
        $this->Apparent_Energy_Delivered_Phase_A = $result['Apparent_Energy_Delivered_Phase_A'];
        $this->Apparent_Energy_Delivered_Phase_B = $result['Apparent_Energy_Delivered_Phase_B'];
        $this->Apparent_Energy_Delivered_Phase_C = $result['Apparent_Energy_Delivered_Phase_C'];
    }


    public function returnAsArray()
    {
        $array['substation_id'] = $this->substation_id;
        $array['unitId'] = $this->unitId;
        $array['Start_time'] = $this->Start_time;
        $array['JStart_time'] = $this->JStart_time;
        $array['Current_A'] = $this->Current_A;
        $array['Current_B'] = $this->Current_B;
        $array['Current_C'] = $this->Current_C;
        $array['Current_N'] = $this->Current_N;
        $array['Current_G'] = $this->Current_G;
        $array['Current_Avg'] = $this->Current_Avg;
        $array['Current_Unbalance_A'] = $this->Current_Unbalance_A;
        $array['Current_Unbalance_B'] = $this->Current_Unbalance_B;
        $array['Current_Unbalance_C'] = $this->Current_Unbalance_C;
        $array['Current_Unbalance_Worst'] = $this->Current_Unbalance_Worst;
        $array['Voltage_A_B'] = $this->Voltage_A_B;
        $array['Voltage_B_C'] = $this->Voltage_B_C;
        $array['Voltage_C_A'] = $this->Voltage_C_A;
        $array['Voltage_L_L_Avg'] = $this->Voltage_L_L_Avg;
        $array['Voltage_A_N'] = $this->Voltage_A_N;
        $array['Voltage_B_N'] = $this->Voltage_B_N;
        $array['Voltage_C_N'] = $this->Voltage_C_N;
        $array['Voltage_L_N_Avg'] = $this->Voltage_L_N_Avg;
        $array['Voltage_Unbalance_A_B'] = $this->Voltage_Unbalance_A_B;
        $array['Voltage_Unbalance_B_C'] = $this->Voltage_Unbalance_B_C;
        $array['Voltage_Unbalance_C_A'] = $this->Voltage_Unbalance_C_A;
        $array['Voltage_Unbalance_L_L_Worst'] = $this->Voltage_Unbalance_L_L_Worst;
        $array['Voltage_Unbalance_A_N'] = $this->Voltage_Unbalance_A_N;
        $array['Voltage_Unbalance_B_N'] = $this->Voltage_Unbalance_B_N;
        $array['Voltage_Unbalance_C_N'] = $this->Voltage_Unbalance_C_N;
        $array['Voltage_Unbalance_L_N_Worst'] = $this->Voltage_Unbalance_L_N_Worst;
        $array['Active_Power_A'] = $this->Active_Power_A;
        $array['Active_Power_B'] = $this->Active_Power_B;
        $array['Active_Power_C'] = $this->Active_Power_C;
        $array['Active_Power_Total'] = $this->Active_Power_Total;
        $array['Reactive_Power_A'] = $this->Reactive_Power_A;
        $array['Reactive_Power_B'] = $this->Reactive_Power_B;
        $array['Reactive_Power_C'] = $this->Reactive_Power_C;
        $array['Reactive_Power_Total'] = $this->Reactive_Power_Total;
        $array['Apparent_Power_A'] = $this->Apparent_Power_A;
        $array['Apparent_Power_B'] = $this->Apparent_Power_B;
        $array['Apparent_Power_C'] = $this->Apparent_Power_C;
        $array['Apparent_Power_Total'] = $this->Apparent_Power_Total;
        $array['Power_Factor_A'] = $this->Power_Factor_A;
        $array['Power_Factor_B'] = $this->Power_Factor_B;
        $array['Power_Factor_C'] = $this->Power_Factor_C;
        $array['Power_Factor_Total'] = $this->Power_Factor_Total;
        $array['Displacement_Power_Factor_A'] = $this->Displacement_Power_Factor_A;
        $array['Displacement_Power_Factor_B'] = $this->Displacement_Power_Factor_B;
        $array['Displacement_Power_Factor_C'] = $this->Displacement_Power_Factor_C;
        $array['Displacement_Power_Factor_Total'] = $this->Displacement_Power_Factor_Total;
        $array['Frequency'] = $this->Frequency;
        $array['Active_Energy_Delivered_Into_Load'] = $this->Active_Energy_Delivered_Into_Load;
        $array['Active_Energy_Received_Out_of_Load'] = $this->Active_Energy_Received_Out_of_Load;
        $array['Active_Energy_Delivered_Pos_Received'] = $this->Active_Energy_Delivered_Pos_Received;
        $array['Active_Energy_Delivered_Neg_Received'] = $this->Active_Energy_Delivered_Neg_Received;
        $array['Reactive_Energy_Delivered'] = $this->Reactive_Energy_Delivered;
        $array['Reactive_Energy_Received'] = $this->Reactive_Energy_Received;
        $array['Reactive_Energy_Delivered_Pos_Received'] = $this->Reactive_Energy_Delivered_Pos_Received;
        $array['Reactive_Energy_Delivered_Neg_Received'] = $this->Reactive_Energy_Delivered_Neg_Received;
        $array['Apparent_Energy_Delivered'] = $this->Apparent_Energy_Delivered;
        $array['Apparent_Energy_Received'] = $this->Apparent_Energy_Received;
        $array['Apparent_Energy_Delivered_Pos_Received'] = $this->Apparent_Energy_Delivered_Pos_Received;
        $array['Apparent_Energy_Delivered_Neg_Received'] = $this->Apparent_Energy_Delivered_Neg_Received;
        $array['Reactive_Energy_in_Quadrant_I'] = $this->Reactive_Energy_in_Quadrant_I;
        $array['Reactive_Energy_in_Quadrant_II'] = $this->Reactive_Energy_in_Quadrant_II;
        $array['Reactive_Energy_in_Quadrant_III'] = $this->Reactive_Energy_in_Quadrant_III;
        $array['Reactive_Energy_in_Quadrant_IV'] = $this->Reactive_Energy_in_Quadrant_IV;
        $array['Active_Energy_Delivered_Into_Load_Permanent'] = $this->Active_Energy_Delivered_Into_Load_Permanent;
        $array['Active_Energy_Received_Out_of_Load_Permanent'] = $this->Active_Energy_Received_Out_of_Load_Permanent;
        $array['Active_Energy_Delivered_Pos_Received_Permanent'] = $this->Active_Energy_Delivered_Pos_Received_Permanent;
        $array['Active_Energy_Delivered_Neg_Received_Permanent'] = $this->Active_Energy_Delivered_Neg_Received_Permanent;
        $array['Reactive_Energy_Delivered_Permanent'] = $this->Reactive_Energy_Delivered_Permanent;
        $array['Reactive_Energy_Received_Permanent'] = $this->Reactive_Energy_Received_Permanent;
        $array['Reactive_Energy_Delivered_Pos_Received_Permanent'] = $this->Reactive_Energy_Delivered_Pos_Received_Permanent;
        $array['Reactive_Energy_Delivered_Neg_Received_Permanent'] = $this->Reactive_Energy_Delivered_Neg_Received_Permanent;
        $array['Apparent_Energy_Delivered_Permanent'] = $this->Apparent_Energy_Delivered_Permanent;
        $array['Apparent_Energy_Received_Permanent'] = $this->Apparent_Energy_Received_Permanent;
        $array['Apparent_Energy_Delivered_Pos_Received_Permanent'] = $this->Apparent_Energy_Delivered_Pos_Received_Permanent;
        $array['Apparent_Energy_Delivered_Neg_Received_Permanent'] = $this->Apparent_Energy_Delivered_Neg_Received_Permanent;
        $array['Active_Energy_Delivered_Phase_A'] = $this->Active_Energy_Delivered_Phase_A;
        $array['Active_Energy_Delivered_Phase_B'] = $this->Active_Energy_Delivered_Phase_B;
        $array['Active_Energy_Delivered_Phase_C'] = $this->Active_Energy_Delivered_Phase_C;
        $array['Reactive_Energy_Delivered_Phase_A'] = $this->Reactive_Energy_Delivered_Phase_A;
        $array['Reactive_Energy_Delivered_Phase_B'] = $this->Reactive_Energy_Delivered_Phase_B;
        $array['Reactive_Energy_Delivered_Phase_C'] = $this->Reactive_Energy_Delivered_Phase_C;
        $array['Apparent_Energy_Delivered_Phase_A'] = $this->Apparent_Energy_Delivered_Phase_A;
        $array['Apparent_Energy_Delivered_Phase_B'] = $this->Apparent_Energy_Delivered_Phase_B;
        $array['Apparent_Energy_Delivered_Phase_C'] = $this->Apparent_Energy_Delivered_Phase_C;
        return $array;
    }

    /**
     * @return mixed
     */
    public function getSubstationId()
    {
        return $this->substation_id;
    }

    /**
     * @param mixed $substation_id
     */
    public function setSubstationId($substation_id)
    {
        $this->substation_id = $substation_id;
    }

    /**
     * @return mixed
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * @param mixed $unitId
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->Start_time;
    }

    /**
     * @param mixed $Start_time
     */
    public function setStartTime($Start_time)
    {
        $this->Start_time = $Start_time;
    }

    /**
     * @return mixed
     */
    public function getJStartTime()
    {
        return $this->JStart_time;
    }

    /**
     * @param mixed $JStart_time
     */
    public function setJStartTime($JStart_time)
    {
        $this->JStart_time = $JStart_time;
    }

    /**
     * @return mixed
     */
    public function getCurrentA()
    {
        return $this->Current_A;
    }

    /**
     * @param mixed $Current_A
     */
    public function setCurrentA($Current_A)
    {
        $this->Current_A = $Current_A;
    }

    /**
     * @return mixed
     */
    public function getCurrentB()
    {
        return $this->Current_B;
    }

    /**
     * @param mixed $Current_B
     */
    public function setCurrentB($Current_B)
    {
        $this->Current_B = $Current_B;
    }

    /**
     * @return mixed
     */
    public function getCurrentC()
    {
        return $this->Current_C;
    }

    /**
     * @param mixed $Current_C
     */
    public function setCurrentC($Current_C)
    {
        $this->Current_C = $Current_C;
    }

    /**
     * @return mixed
     */
    public function getCurrentN()
    {
        return $this->Current_N;
    }

    /**
     * @param mixed $Current_N
     */
    public function setCurrentN($Current_N)
    {
        $this->Current_N = $Current_N;
    }

    /**
     * @return mixed
     */
    public function getCurrentG()
    {
        return $this->Current_G;
    }

    /**
     * @param mixed $Current_G
     */
    public function setCurrentG($Current_G)
    {
        $this->Current_G = $Current_G;
    }

    /**
     * @return mixed
     */
    public function getCurrentAvg()
    {
        return $this->Current_Avg;
    }

    /**
     * @param mixed $Current_Avg
     */
    public function setCurrentAvg($Current_Avg)
    {
        $this->Current_Avg = $Current_Avg;
    }

    /**
     * @return mixed
     */
    public function getCurrentUnbalanceA()
    {
        return $this->Current_Unbalance_A;
    }

    /**
     * @param mixed $Current_Unbalance_A
     */
    public function setCurrentUnbalanceA($Current_Unbalance_A)
    {
        $this->Current_Unbalance_A = $Current_Unbalance_A;
    }

    /**
     * @return mixed
     */
    public function getCurrentUnbalanceB()
    {
        return $this->Current_Unbalance_B;
    }

    /**
     * @param mixed $Current_Unbalance_B
     */
    public function setCurrentUnbalanceB($Current_Unbalance_B)
    {
        $this->Current_Unbalance_B = $Current_Unbalance_B;
    }

    /**
     * @return mixed
     */
    public function getCurrentUnbalanceC()
    {
        return $this->Current_Unbalance_C;
    }

    /**
     * @param mixed $Current_Unbalance_C
     */
    public function setCurrentUnbalanceC($Current_Unbalance_C)
    {
        $this->Current_Unbalance_C = $Current_Unbalance_C;
    }

    /**
     * @return mixed
     */
    public function getCurrentUnbalanceWorst()
    {
        return $this->Current_Unbalance_Worst;
    }

    /**
     * @param mixed $Current_Unbalance_Worst
     */
    public function setCurrentUnbalanceWorst($Current_Unbalance_Worst)
    {
        $this->Current_Unbalance_Worst = $Current_Unbalance_Worst;
    }

    /**
     * @return mixed
     */
    public function getVoltageAB()
    {
        return $this->Voltage_A_B;
    }

    /**
     * @param mixed $Voltage_A_B
     */
    public function setVoltageAB($Voltage_A_B)
    {
        $this->Voltage_A_B = $Voltage_A_B;
    }

    /**
     * @return mixed
     */
    public function getVoltageBC()
    {
        return $this->Voltage_B_C;
    }

    /**
     * @param mixed $Voltage_B_C
     */
    public function setVoltageBC($Voltage_B_C)
    {
        $this->Voltage_B_C = $Voltage_B_C;
    }

    /**
     * @return mixed
     */
    public function getVoltageCA()
    {
        return $this->Voltage_C_A;
    }

    /**
     * @param mixed $Voltage_C_A
     */
    public function setVoltageCA($Voltage_C_A)
    {
        $this->Voltage_C_A = $Voltage_C_A;
    }

    /**
     * @return mixed
     */
    public function getVoltageLLAvg()
    {
        return $this->Voltage_L_L_Avg;
    }

    /**
     * @param mixed $Voltage_L_L_Avg
     */
    public function setVoltageLLAvg($Voltage_L_L_Avg)
    {
        $this->Voltage_L_L_Avg = $Voltage_L_L_Avg;
    }

    /**
     * @return mixed
     */
    public function getVoltageAN()
    {
        return $this->Voltage_A_N;
    }

    /**
     * @param mixed $Voltage_A_N
     */
    public function setVoltageAN($Voltage_A_N)
    {
        $this->Voltage_A_N = $Voltage_A_N;
    }

    /**
     * @return mixed
     */
    public function getVoltageBN()
    {
        return $this->Voltage_B_N;
    }

    /**
     * @param mixed $Voltage_B_N
     */
    public function setVoltageBN($Voltage_B_N)
    {
        $this->Voltage_B_N = $Voltage_B_N;
    }

    /**
     * @return mixed
     */
    public function getVoltageCN()
    {
        return $this->Voltage_C_N;
    }

    /**
     * @param mixed $Voltage_C_N
     */
    public function setVoltageCN($Voltage_C_N)
    {
        $this->Voltage_C_N = $Voltage_C_N;
    }

    /**
     * @return mixed
     */
    public function getVoltageLNAvg()
    {
        return $this->Voltage_L_N_Avg;
    }

    /**
     * @param mixed $Voltage_L_N_Avg
     */
    public function setVoltageLNAvg($Voltage_L_N_Avg)
    {
        $this->Voltage_L_N_Avg = $Voltage_L_N_Avg;
    }

    /**
     * @return mixed
     */
    public function getVoltageUnbalanceAB()
    {
        return $this->Voltage_Unbalance_A_B;
    }

    /**
     * @param mixed $Voltage_Unbalance_A_B
     */
    public function setVoltageUnbalanceAB($Voltage_Unbalance_A_B)
    {
        $this->Voltage_Unbalance_A_B = $Voltage_Unbalance_A_B;
    }

    /**
     * @return mixed
     */
    public function getVoltageUnbalanceBC()
    {
        return $this->Voltage_Unbalance_B_C;
    }

    /**
     * @param mixed $Voltage_Unbalance_B_C
     */
    public function setVoltageUnbalanceBC($Voltage_Unbalance_B_C)
    {
        $this->Voltage_Unbalance_B_C = $Voltage_Unbalance_B_C;
    }

    /**
     * @return mixed
     */
    public function getVoltageUnbalanceCA()
    {
        return $this->Voltage_Unbalance_C_A;
    }

    /**
     * @param mixed $Voltage_Unbalance_C_A
     */
    public function setVoltageUnbalanceCA($Voltage_Unbalance_C_A)
    {
        $this->Voltage_Unbalance_C_A = $Voltage_Unbalance_C_A;
    }

    /**
     * @return mixed
     */
    public function getVoltageUnbalanceLLWorst()
    {
        return $this->Voltage_Unbalance_L_L_Worst;
    }

    /**
     * @param mixed $Voltage_Unbalance_L_L_Worst
     */
    public function setVoltageUnbalanceLLWorst($Voltage_Unbalance_L_L_Worst)
    {
        $this->Voltage_Unbalance_L_L_Worst = $Voltage_Unbalance_L_L_Worst;
    }

    /**
     * @return mixed
     */
    public function getVoltageUnbalanceAN()
    {
        return $this->Voltage_Unbalance_A_N;
    }

    /**
     * @param mixed $Voltage_Unbalance_A_N
     */
    public function setVoltageUnbalanceAN($Voltage_Unbalance_A_N)
    {
        $this->Voltage_Unbalance_A_N = $Voltage_Unbalance_A_N;
    }

    /**
     * @return mixed
     */
    public function getVoltageUnbalanceBN()
    {
        return $this->Voltage_Unbalance_B_N;
    }

    /**
     * @param mixed $Voltage_Unbalance_B_N
     */
    public function setVoltageUnbalanceBN($Voltage_Unbalance_B_N)
    {
        $this->Voltage_Unbalance_B_N = $Voltage_Unbalance_B_N;
    }

    /**
     * @return mixed
     */
    public function getVoltageUnbalanceCN()
    {
        return $this->Voltage_Unbalance_C_N;
    }

    /**
     * @param mixed $Voltage_Unbalance_C_N
     */
    public function setVoltageUnbalanceCN($Voltage_Unbalance_C_N)
    {
        $this->Voltage_Unbalance_C_N = $Voltage_Unbalance_C_N;
    }

    /**
     * @return mixed
     */
    public function getVoltageUnbalanceLNWorst()
    {
        return $this->Voltage_Unbalance_L_N_Worst;
    }

    /**
     * @param mixed $Voltage_Unbalance_L_N_Worst
     */
    public function setVoltageUnbalanceLNWorst($Voltage_Unbalance_L_N_Worst)
    {
        $this->Voltage_Unbalance_L_N_Worst = $Voltage_Unbalance_L_N_Worst;
    }

    /**
     * @return mixed
     */
    public function getActivePowerA()
    {
        return $this->Active_Power_A;
    }

    /**
     * @param mixed $Active_Power_A
     */
    public function setActivePowerA($Active_Power_A)
    {
        $this->Active_Power_A = $Active_Power_A;
    }

    /**
     * @return mixed
     */
    public function getActivePowerB()
    {
        return $this->Active_Power_B;
    }

    /**
     * @param mixed $Active_Power_B
     */
    public function setActivePowerB($Active_Power_B)
    {
        $this->Active_Power_B = $Active_Power_B;
    }

    /**
     * @return mixed
     */
    public function getActivePowerC()
    {
        return $this->Active_Power_C;
    }

    /**
     * @param mixed $Active_Power_C
     */
    public function setActivePowerC($Active_Power_C)
    {
        $this->Active_Power_C = $Active_Power_C;
    }

    /**
     * @return mixed
     */
    public function getActivePowerTotal()
    {
        return $this->Active_Power_Total;
    }

    /**
     * @param mixed $Active_Power_Total
     */
    public function setActivePowerTotal($Active_Power_Total)
    {
        $this->Active_Power_Total = $Active_Power_Total;
    }

    /**
     * @return mixed
     */
    public function getReactivePowerA()
    {
        return $this->Reactive_Power_A;
    }

    /**
     * @param mixed $Reactive_Power_A
     */
    public function setReactivePowerA($Reactive_Power_A)
    {
        $this->Reactive_Power_A = $Reactive_Power_A;
    }

    /**
     * @return mixed
     */
    public function getReactivePowerB()
    {
        return $this->Reactive_Power_B;
    }

    /**
     * @param mixed $Reactive_Power_B
     */
    public function setReactivePowerB($Reactive_Power_B)
    {
        $this->Reactive_Power_B = $Reactive_Power_B;
    }

    /**
     * @return mixed
     */
    public function getReactivePowerC()
    {
        return $this->Reactive_Power_C;
    }

    /**
     * @param mixed $Reactive_Power_C
     */
    public function setReactivePowerC($Reactive_Power_C)
    {
        $this->Reactive_Power_C = $Reactive_Power_C;
    }

    /**
     * @return mixed
     */
    public function getReactivePowerTotal()
    {
        return $this->Reactive_Power_Total;
    }

    /**
     * @param mixed $Reactive_Power_Total
     */
    public function setReactivePowerTotal($Reactive_Power_Total)
    {
        $this->Reactive_Power_Total = $Reactive_Power_Total;
    }

    /**
     * @return mixed
     */
    public function getApparentPowerA()
    {
        return $this->Apparent_Power_A;
    }

    /**
     * @param mixed $Apparent_Power_A
     */
    public function setApparentPowerA($Apparent_Power_A)
    {
        $this->Apparent_Power_A = $Apparent_Power_A;
    }

    /**
     * @return mixed
     */
    public function getApparentPowerB()
    {
        return $this->Apparent_Power_B;
    }

    /**
     * @param mixed $Apparent_Power_B
     */
    public function setApparentPowerB($Apparent_Power_B)
    {
        $this->Apparent_Power_B = $Apparent_Power_B;
    }

    /**
     * @return mixed
     */
    public function getApparentPowerC()
    {
        return $this->Apparent_Power_C;
    }

    /**
     * @param mixed $Apparent_Power_C
     */
    public function setApparentPowerC($Apparent_Power_C)
    {
        $this->Apparent_Power_C = $Apparent_Power_C;
    }

    /**
     * @return mixed
     */
    public function getApparentPowerTotal()
    {
        return $this->Apparent_Power_Total;
    }

    /**
     * @param mixed $Apparent_Power_Total
     */
    public function setApparentPowerTotal($Apparent_Power_Total)
    {
        $this->Apparent_Power_Total = $Apparent_Power_Total;
    }

    /**
     * @return mixed
     */
    public function getPowerFactorA()
    {
        return $this->Power_Factor_A;
    }

    /**
     * @param mixed $Power_Factor_A
     */
    public function setPowerFactorA($Power_Factor_A)
    {
        $this->Power_Factor_A = $Power_Factor_A;
    }

    /**
     * @return mixed
     */
    public function getPowerFactorB()
    {
        return $this->Power_Factor_B;
    }

    /**
     * @param mixed $Power_Factor_B
     */
    public function setPowerFactorB($Power_Factor_B)
    {
        $this->Power_Factor_B = $Power_Factor_B;
    }

    /**
     * @return mixed
     */
    public function getPowerFactorC()
    {
        return $this->Power_Factor_C;
    }

    /**
     * @param mixed $Power_Factor_C
     */
    public function setPowerFactorC($Power_Factor_C)
    {
        $this->Power_Factor_C = $Power_Factor_C;
    }

    /**
     * @return mixed
     */
    public function getPowerFactorTotal()
    {
        return $this->Power_Factor_Total;
    }

    /**
     * @param mixed $Power_Factor_Total
     */
    public function setPowerFactorTotal($Power_Factor_Total)
    {
        $this->Power_Factor_Total = $Power_Factor_Total;
    }

    /**
     * @return mixed
     */
    public function getDisplacementPowerFactorA()
    {
        return $this->Displacement_Power_Factor_A;
    }

    /**
     * @param mixed $Displacement_Power_Factor_A
     */
    public function setDisplacementPowerFactorA($Displacement_Power_Factor_A)
    {
        $this->Displacement_Power_Factor_A = $Displacement_Power_Factor_A;
    }

    /**
     * @return mixed
     */
    public function getDisplacementPowerFactorB()
    {
        return $this->Displacement_Power_Factor_B;
    }

    /**
     * @param mixed $Displacement_Power_Factor_B
     */
    public function setDisplacementPowerFactorB($Displacement_Power_Factor_B)
    {
        $this->Displacement_Power_Factor_B = $Displacement_Power_Factor_B;
    }

    /**
     * @return mixed
     */
    public function getDisplacementPowerFactorC()
    {
        return $this->Displacement_Power_Factor_C;
    }

    /**
     * @param mixed $Displacement_Power_Factor_C
     */
    public function setDisplacementPowerFactorC($Displacement_Power_Factor_C)
    {
        $this->Displacement_Power_Factor_C = $Displacement_Power_Factor_C;
    }

    /**
     * @return mixed
     */
    public function getDisplacementPowerFactorTotal()
    {
        return $this->Displacement_Power_Factor_Total;
    }

    /**
     * @param mixed $Displacement_Power_Factor_Total
     */
    public function setDisplacementPowerFactorTotal($Displacement_Power_Factor_Total)
    {
        $this->Displacement_Power_Factor_Total = $Displacement_Power_Factor_Total;
    }

    /**
     * @return mixed
     */
    public function getFrequency()
    {
        return $this->Frequency;
    }

    /**
     * @param mixed $Frequency
     */
    public function setFrequency($Frequency)
    {
        $this->Frequency = $Frequency;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyDeliveredIntoLoad()
    {
        return $this->Active_Energy_Delivered_Into_Load;
    }

    /**
     * @param mixed $Active_Energy_Delivered_Into_Load
     */
    public function setActiveEnergyDeliveredIntoLoad($Active_Energy_Delivered_Into_Load)
    {
        $this->Active_Energy_Delivered_Into_Load = $Active_Energy_Delivered_Into_Load;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyReceivedOutOfLoad()
    {
        return $this->Active_Energy_Received_Out_of_Load;
    }

    /**
     * @param mixed $Active_Energy_Received_Out_of_Load
     */
    public function setActiveEnergyReceivedOutOfLoad($Active_Energy_Received_Out_of_Load)
    {
        $this->Active_Energy_Received_Out_of_Load = $Active_Energy_Received_Out_of_Load;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyDeliveredPosReceived()
    {
        return $this->Active_Energy_Delivered_Pos_Received;
    }

    /**
     * @param mixed $Active_Energy_Delivered_Pos_Received
     */
    public function setActiveEnergyDeliveredPosReceived($Active_Energy_Delivered_Pos_Received)
    {
        $this->Active_Energy_Delivered_Pos_Received = $Active_Energy_Delivered_Pos_Received;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyDeliveredNegReceived()
    {
        return $this->Active_Energy_Delivered_Neg_Received;
    }

    /**
     * @param mixed $Active_Energy_Delivered_Neg_Received
     */
    public function setActiveEnergyDeliveredNegReceived($Active_Energy_Delivered_Neg_Received)
    {
        $this->Active_Energy_Delivered_Neg_Received = $Active_Energy_Delivered_Neg_Received;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyDelivered()
    {
        return $this->Reactive_Energy_Delivered;
    }

    /**
     * @param mixed $Reactive_Energy_Delivered
     */
    public function setReactiveEnergyDelivered($Reactive_Energy_Delivered)
    {
        $this->Reactive_Energy_Delivered = $Reactive_Energy_Delivered;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyReceived()
    {
        return $this->Reactive_Energy_Received;
    }

    /**
     * @param mixed $Reactive_Energy_Received
     */
    public function setReactiveEnergyReceived($Reactive_Energy_Received)
    {
        $this->Reactive_Energy_Received = $Reactive_Energy_Received;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyDeliveredPosReceived()
    {
        return $this->Reactive_Energy_Delivered_Pos_Received;
    }

    /**
     * @param mixed $Reactive_Energy_Delivered_Pos_Received
     */
    public function setReactiveEnergyDeliveredPosReceived($Reactive_Energy_Delivered_Pos_Received)
    {
        $this->Reactive_Energy_Delivered_Pos_Received = $Reactive_Energy_Delivered_Pos_Received;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyDeliveredNegReceived()
    {
        return $this->Reactive_Energy_Delivered_Neg_Received;
    }

    /**
     * @param mixed $Reactive_Energy_Delivered_Neg_Received
     */
    public function setReactiveEnergyDeliveredNegReceived($Reactive_Energy_Delivered_Neg_Received)
    {
        $this->Reactive_Energy_Delivered_Neg_Received = $Reactive_Energy_Delivered_Neg_Received;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyDelivered()
    {
        return $this->Apparent_Energy_Delivered;
    }

    /**
     * @param mixed $Apparent_Energy_Delivered
     */
    public function setApparentEnergyDelivered($Apparent_Energy_Delivered)
    {
        $this->Apparent_Energy_Delivered = $Apparent_Energy_Delivered;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyReceived()
    {
        return $this->Apparent_Energy_Received;
    }

    /**
     * @param mixed $Apparent_Energy_Received
     */
    public function setApparentEnergyReceived($Apparent_Energy_Received)
    {
        $this->Apparent_Energy_Received = $Apparent_Energy_Received;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyDeliveredPosReceived()
    {
        return $this->Apparent_Energy_Delivered_Pos_Received;
    }

    /**
     * @param mixed $Apparent_Energy_Delivered_Pos_Received
     */
    public function setApparentEnergyDeliveredPosReceived($Apparent_Energy_Delivered_Pos_Received)
    {
        $this->Apparent_Energy_Delivered_Pos_Received = $Apparent_Energy_Delivered_Pos_Received;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyDeliveredNegReceived()
    {
        return $this->Apparent_Energy_Delivered_Neg_Received;
    }

    /**
     * @param mixed $Apparent_Energy_Delivered_Neg_Received
     */
    public function setApparentEnergyDeliveredNegReceived($Apparent_Energy_Delivered_Neg_Received)
    {
        $this->Apparent_Energy_Delivered_Neg_Received = $Apparent_Energy_Delivered_Neg_Received;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyInQuadrantI()
    {
        return $this->Reactive_Energy_in_Quadrant_I;
    }

    /**
     * @param mixed $Reactive_Energy_in_Quadrant_I
     */
    public function setReactiveEnergyInQuadrantI($Reactive_Energy_in_Quadrant_I)
    {
        $this->Reactive_Energy_in_Quadrant_I = $Reactive_Energy_in_Quadrant_I;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyInQuadrantII()
    {
        return $this->Reactive_Energy_in_Quadrant_II;
    }

    /**
     * @param mixed $Reactive_Energy_in_Quadrant_II
     */
    public function setReactiveEnergyInQuadrantII($Reactive_Energy_in_Quadrant_II)
    {
        $this->Reactive_Energy_in_Quadrant_II = $Reactive_Energy_in_Quadrant_II;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyInQuadrantIII()
    {
        return $this->Reactive_Energy_in_Quadrant_III;
    }

    /**
     * @param mixed $Reactive_Energy_in_Quadrant_III
     */
    public function setReactiveEnergyInQuadrantIII($Reactive_Energy_in_Quadrant_III)
    {
        $this->Reactive_Energy_in_Quadrant_III = $Reactive_Energy_in_Quadrant_III;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyInQuadrantIV()
    {
        return $this->Reactive_Energy_in_Quadrant_IV;
    }

    /**
     * @param mixed $Reactive_Energy_in_Quadrant_IV
     */
    public function setReactiveEnergyInQuadrantIV($Reactive_Energy_in_Quadrant_IV)
    {
        $this->Reactive_Energy_in_Quadrant_IV = $Reactive_Energy_in_Quadrant_IV;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyDeliveredIntoLoadPermanent()
    {
        return $this->Active_Energy_Delivered_Into_Load_Permanent;
    }

    /**
     * @param mixed $Active_Energy_Delivered_Into_Load_Permanent
     */
    public function setActiveEnergyDeliveredIntoLoadPermanent($Active_Energy_Delivered_Into_Load_Permanent)
    {
        $this->Active_Energy_Delivered_Into_Load_Permanent = $Active_Energy_Delivered_Into_Load_Permanent;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyReceivedOutOfLoadPermanent()
    {
        return $this->Active_Energy_Received_Out_of_Load_Permanent;
    }

    /**
     * @param mixed $Active_Energy_Received_Out_of_Load_Permanent
     */
    public function setActiveEnergyReceivedOutOfLoadPermanent($Active_Energy_Received_Out_of_Load_Permanent)
    {
        $this->Active_Energy_Received_Out_of_Load_Permanent = $Active_Energy_Received_Out_of_Load_Permanent;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyDeliveredPosReceivedPermanent()
    {
        return $this->Active_Energy_Delivered_Pos_Received_Permanent;
    }

    /**
     * @param mixed $Active_Energy_Delivered_Pos_Received_Permanent
     */
    public function setActiveEnergyDeliveredPosReceivedPermanent($Active_Energy_Delivered_Pos_Received_Permanent)
    {
        $this->Active_Energy_Delivered_Pos_Received_Permanent = $Active_Energy_Delivered_Pos_Received_Permanent;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyDeliveredNegReceivedPermanent()
    {
        return $this->Active_Energy_Delivered_Neg_Received_Permanent;
    }

    /**
     * @param mixed $Active_Energy_Delivered_Neg_Received_Permanent
     */
    public function setActiveEnergyDeliveredNegReceivedPermanent($Active_Energy_Delivered_Neg_Received_Permanent)
    {
        $this->Active_Energy_Delivered_Neg_Received_Permanent = $Active_Energy_Delivered_Neg_Received_Permanent;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyDeliveredPermanent()
    {
        return $this->Reactive_Energy_Delivered_Permanent;
    }

    /**
     * @param mixed $Reactive_Energy_Delivered_Permanent
     */
    public function setReactiveEnergyDeliveredPermanent($Reactive_Energy_Delivered_Permanent)
    {
        $this->Reactive_Energy_Delivered_Permanent = $Reactive_Energy_Delivered_Permanent;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyReceivedPermanent()
    {
        return $this->Reactive_Energy_Received_Permanent;
    }

    /**
     * @param mixed $Reactive_Energy_Received_Permanent
     */
    public function setReactiveEnergyReceivedPermanent($Reactive_Energy_Received_Permanent)
    {
        $this->Reactive_Energy_Received_Permanent = $Reactive_Energy_Received_Permanent;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyDeliveredPosReceivedPermanent()
    {
        return $this->Reactive_Energy_Delivered_Pos_Received_Permanent;
    }

    /**
     * @param mixed $Reactive_Energy_Delivered_Pos_Received_Permanent
     */
    public function setReactiveEnergyDeliveredPosReceivedPermanent($Reactive_Energy_Delivered_Pos_Received_Permanent)
    {
        $this->Reactive_Energy_Delivered_Pos_Received_Permanent = $Reactive_Energy_Delivered_Pos_Received_Permanent;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyDeliveredNegReceivedPermanent()
    {
        return $this->Reactive_Energy_Delivered_Neg_Received_Permanent;
    }

    /**
     * @param mixed $Reactive_Energy_Delivered_Neg_Received_Permanent
     */
    public function setReactiveEnergyDeliveredNegReceivedPermanent($Reactive_Energy_Delivered_Neg_Received_Permanent)
    {
        $this->Reactive_Energy_Delivered_Neg_Received_Permanent = $Reactive_Energy_Delivered_Neg_Received_Permanent;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyDeliveredPermanent()
    {
        return $this->Apparent_Energy_Delivered_Permanent;
    }

    /**
     * @param mixed $Apparent_Energy_Delivered_Permanent
     */
    public function setApparentEnergyDeliveredPermanent($Apparent_Energy_Delivered_Permanent)
    {
        $this->Apparent_Energy_Delivered_Permanent = $Apparent_Energy_Delivered_Permanent;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyReceivedPermanent()
    {
        return $this->Apparent_Energy_Received_Permanent;
    }

    /**
     * @param mixed $Apparent_Energy_Received_Permanent
     */
    public function setApparentEnergyReceivedPermanent($Apparent_Energy_Received_Permanent)
    {
        $this->Apparent_Energy_Received_Permanent = $Apparent_Energy_Received_Permanent;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyDeliveredPosReceivedPermanent()
    {
        return $this->Apparent_Energy_Delivered_Pos_Received_Permanent;
    }

    /**
     * @param mixed $Apparent_Energy_Delivered_Pos_Received_Permanent
     */
    public function setApparentEnergyDeliveredPosReceivedPermanent($Apparent_Energy_Delivered_Pos_Received_Permanent)
    {
        $this->Apparent_Energy_Delivered_Pos_Received_Permanent = $Apparent_Energy_Delivered_Pos_Received_Permanent;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyDeliveredNegReceivedPermanent()
    {
        return $this->Apparent_Energy_Delivered_Neg_Received_Permanent;
    }

    /**
     * @param mixed $Apparent_Energy_Delivered_Neg_Received_Permanent
     */
    public function setApparentEnergyDeliveredNegReceivedPermanent($Apparent_Energy_Delivered_Neg_Received_Permanent)
    {
        $this->Apparent_Energy_Delivered_Neg_Received_Permanent = $Apparent_Energy_Delivered_Neg_Received_Permanent;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyDeliveredPhaseA()
    {
        return $this->Active_Energy_Delivered_Phase_A;
    }

    /**
     * @param mixed $Active_Energy_Delivered_Phase_A
     */
    public function setActiveEnergyDeliveredPhaseA($Active_Energy_Delivered_Phase_A)
    {
        $this->Active_Energy_Delivered_Phase_A = $Active_Energy_Delivered_Phase_A;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyDeliveredPhaseB()
    {
        return $this->Active_Energy_Delivered_Phase_B;
    }

    /**
     * @param mixed $Active_Energy_Delivered_Phase_B
     */
    public function setActiveEnergyDeliveredPhaseB($Active_Energy_Delivered_Phase_B)
    {
        $this->Active_Energy_Delivered_Phase_B = $Active_Energy_Delivered_Phase_B;
    }

    /**
     * @return mixed
     */
    public function getActiveEnergyDeliveredPhaseC()
    {
        return $this->Active_Energy_Delivered_Phase_C;
    }

    /**
     * @param mixed $Active_Energy_Delivered_Phase_C
     */
    public function setActiveEnergyDeliveredPhaseC($Active_Energy_Delivered_Phase_C)
    {
        $this->Active_Energy_Delivered_Phase_C = $Active_Energy_Delivered_Phase_C;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyDeliveredPhaseA()
    {
        return $this->Reactive_Energy_Delivered_Phase_A;
    }

    /**
     * @param mixed $Reactive_Energy_Delivered_Phase_A
     */
    public function setReactiveEnergyDeliveredPhaseA($Reactive_Energy_Delivered_Phase_A)
    {
        $this->Reactive_Energy_Delivered_Phase_A = $Reactive_Energy_Delivered_Phase_A;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyDeliveredPhaseB()
    {
        return $this->Reactive_Energy_Delivered_Phase_B;
    }

    /**
     * @param mixed $Reactive_Energy_Delivered_Phase_B
     */
    public function setReactiveEnergyDeliveredPhaseB($Reactive_Energy_Delivered_Phase_B)
    {
        $this->Reactive_Energy_Delivered_Phase_B = $Reactive_Energy_Delivered_Phase_B;
    }

    /**
     * @return mixed
     */
    public function getReactiveEnergyDeliveredPhaseC()
    {
        return $this->Reactive_Energy_Delivered_Phase_C;
    }

    /**
     * @param mixed $Reactive_Energy_Delivered_Phase_C
     */
    public function setReactiveEnergyDeliveredPhaseC($Reactive_Energy_Delivered_Phase_C)
    {
        $this->Reactive_Energy_Delivered_Phase_C = $Reactive_Energy_Delivered_Phase_C;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyDeliveredPhaseA()
    {
        return $this->Apparent_Energy_Delivered_Phase_A;
    }

    /**
     * @param mixed $Apparent_Energy_Delivered_Phase_A
     */
    public function setApparentEnergyDeliveredPhaseA($Apparent_Energy_Delivered_Phase_A)
    {
        $this->Apparent_Energy_Delivered_Phase_A = $Apparent_Energy_Delivered_Phase_A;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyDeliveredPhaseB()
    {
        return $this->Apparent_Energy_Delivered_Phase_B;
    }

    /**
     * @param mixed $Apparent_Energy_Delivered_Phase_B
     */
    public function setApparentEnergyDeliveredPhaseB($Apparent_Energy_Delivered_Phase_B)
    {
        $this->Apparent_Energy_Delivered_Phase_B = $Apparent_Energy_Delivered_Phase_B;
    }

    /**
     * @return mixed
     */
    public function getApparentEnergyDeliveredPhaseC()
    {
        return $this->Apparent_Energy_Delivered_Phase_C;
    }

    /**
     * @param mixed $Apparent_Energy_Delivered_Phase_C
     */
    public function setApparentEnergyDeliveredPhaseC($Apparent_Energy_Delivered_Phase_C)
    {
        $this->Apparent_Energy_Delivered_Phase_C = $Apparent_Energy_Delivered_Phase_C;
    }


    /**
     * @return array
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate()
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
    }


    public function clear($Shift_id, $Shift_group_id)
    {
//		parent::deleteOnFullQuery([ date('Y-m-d 00:00:00') ] , ' DATE(Start_time) < ? ');
        parent::deleteOnFullQuery([$Shift_id, $Shift_group_id, -1], ' (Shift_id != ? or Shift_group_id != ?) AND (Shift_id <> ?)');
    }

    public function mergeDB()
    {
        $db = (model::db());
        $perfix = $db::$prefix;
        $tempDBName = $perfix . 'temp_merge_data';
        $DBName = $perfix . 'data';
        model::queryUnprepared('DROP TABLE IF EXISTS ' . $tempDBName . ';');
        model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS ' . $tempDBName . ' select `Sensor_id`,`Start_time`,`JStart_time`,`AbsTime`,SUM(`counter`) as `counter` from ' . $DBName . ' WHERE `Shift_id` = -1 GROUP BY `Sensor_id`;');
        model::queryUnprepared('DELETE FROM ' . $perfix . 'data WHERE `Shift_id` = -1 AND Shift_group_id = -1;');
        model::queryUnprepared('UPDATE  ' . $DBName . ' AS data LEFT JOIN ' . $tempDBName . ' tdata on ( data.Sensor_id = tdata.Sensor_id) SET data.counter = tdata.counter , data.Start_time = NOW() , data.JStart_time = tdata.JStart_time  WHERE  data.Shift_id = -1 AND data.Shift_group_id = 0;');
    }

    public function InsertZeroStorage($SensorID, $Tile_Kind, $phase, $unitId, $tileDegree)
    {
        $db = (model::db());
        $perfix = $db::$prefix;
        model::queryUnprepared('INSERT INTO ' . $perfix . 'data(`Sensor_id`, `AbsTime`, `counter`, `Shift_id`, `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unitId`, `tileDegree`) VALUES (' . $SensorID . ',100,0,-1,0,-1,' . $Tile_Kind . ',100,' . $phase . ',' . $unitId . ',"' . $tileDegree . '");');
    }

    public function UpdateZeroStorage($SensorID, $Tile_Kind, $phase, $unitId, $tileDegree)
    {
        $db = (model::db());
        $perfix = $db::$prefix;
        model::queryUnprepared('UPDATE ' . $perfix . 'data SET Tile_Kind="' . $Tile_Kind . '",phase="' . $phase . '",unitId="' . $unitId . '",tileDegree="' . $tileDegree . '" WHERE Shift_id = -1 AND Shift_group_id = 0 AND Sensor_id = "' . $SensorID . '";');
    }

    public function getData($field, $value = array(), $variable = array()): array
    {
        $value[] = $this->getUnitId();
        $variable[] = 'unitId = ?';

        $value[] = $this->getSubstationId();
        $variable[] = 'substation_id = ?';

        $time = parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'elecsub_data', 'Max(Start_time) as maxTime')[0]['maxTime'];
        $value[] = $time;
        $variable[] = "Start_time = ?";

        $data = array();
        for ($i = 0; $i < count($field); $i++) {
            if ($field[$i] != null)
                $fieldTemp = 'ROUND( ' .$field[$i]. ' , 2 ) as ' . $field[$i];
                $data[] = parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'elecsub_data', $fieldTemp)[0][$field[$i]];
            else
                $data[] = "";
        }
        $data[] = parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'elecsub_data', 'concat(DATE_FORMAT(JStart_time, "%Y.%m.%d")," ",DATE_FORMAT(Start_time, "%H:%i")) as time')[0]['time'];
        $data[] = JDate::jdate("Y.m.d H:i:s");
        return $data;
    }
}
