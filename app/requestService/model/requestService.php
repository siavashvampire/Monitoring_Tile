<?php


namespace App\requestService\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class requestService extends model implements modelInterFace
{

    private $primaryKey = ['requestId'];
    private $primaryKeyShouldNotInsertOrUpdate = 'requestId';
    private $requestId;
    private $requestCode;
    private $Time_Send;
    private $JTime_Send;
    private $Time_Start;
    private $Time_End;
    private $System_Name;
    private $phase;
    private $section;
    private $Line;
    private $Cost;
    private $WorkerSection;
    private $offTime;
    private $System_Status;
    private $WorkTitle;
    private $BugInfluence;
    private $latency;
    private $latencyTime;
    private $failure;
    private $failureDes;
    private $donework;
    private $doneworkDes;
    private $unitPerson_id;
    private $workerPerson_id;
    private $Sender_note;
    private $HumanNumber;
    private $Consumable_Parts;
    private $Consumable_Parts_Qty;

    public function setFromArray($result)
    {
        $this->requestId = $result['requestId'];
        $this->requestCode = $result['requestCode'];
        $this->Time_Send = $result['Time_Send'];
        $this->JTime_Send = $result['JTime_Send'];
        $this->Time_Start = $result['Time_Start'];
        $this->Time_End = $result['Time_End'];
        $this->System_Name = $result['System_Name'];
        $this->phase = $result['phase'];
        $this->section = $result['section'];
        $this->Line = $result['Line'];
        $this->Cost = $result['Cost'];
        $this->WorkerSection = $result['WorkerSection'];
        $this->offTime = $result['offTime'];
        $this->System_Status = $result['System_Status'];
        $this->WorkTitle = $result['WorkTitle'];
        $this->BugInfluence = $result['BugInfluence'];
        $this->latency = $result['latency'];
        $this->latencyTime = $result['latencyTime'];
        $this->failure = $result['failure'];
        $this->failureDes = $result['failureDes'];
        $this->donework = $result['donework'];
        $this->doneworkDes = $result['doneworkDes'];
        $this->unitPerson_id = $result['unitPerson_id'];
        $this->workerPerson_id = $result['workerPerson_id'];
        $this->Sender_note = $result['Sender_note'];
        $this->HumanNumber = $result['HumanNumber'];
        $this->Consumable_Parts = $result['Consumable_Parts'];
        $this->Consumable_Parts_Qty = $result['Consumable_Parts_Qty'];
    }

    public function returnAsArray()
    {
        $array['requestId'] = $this->requestId;
        $array['requestCode'] = $this->requestCode;
        $array['Time_Send'] = $this->Time_Send;
        $array['JTime_Send'] = $this->JTime_Send;
        $array['Time_Start'] = $this->Time_Start;
        $array['Time_End'] = $this->Time_End;
        $array['System_Name'] = $this->System_Name;
        $array['phase'] = $this->phase;
        $array['section'] = $this->section;
        $array['Line'] = $this->Line;
        $array['Cost'] = $this->Cost;
        $array['WorkerSection'] = $this->WorkerSection;
        $array['offTime'] = $this->offTime;
        $array['System_Status'] = $this->System_Status;
        $array['WorkTitle'] = $this->WorkTitle;
        $array['BugInfluence'] = $this->BugInfluence;
        $array['latency'] = $this->latency;
        $array['latencyTime'] = $this->latencyTime;
        $array['failure'] = $this->failure;
        $array['failureDes'] = $this->failureDes;
        $array['donework'] = $this->donework;
        $array['doneworkDes'] = $this->doneworkDes;
        $array['unitPerson_id'] = $this->unitPerson_id;
        $array['workerPerson_id'] = $this->workerPerson_id;
        $array['Sender_note'] = $this->Sender_note;
        $array['HumanNumber'] = $this->HumanNumber;
        $array['Consumable_Parts'] = $this->Consumable_Parts;
        $array['Consumable_Parts_Qty'] = $this->Consumable_Parts_Qty;
        return $array;

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

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param mixed $requestId
     */
    public function setRequestId($requestId): void
    {
        $this->requestId = $requestId;
    }

    /**
     * @return mixed
     */
    public function getRequestCode()
    {
        return $this->requestCode;
    }

    /**
     * @param mixed $requestCode
     */
    public function setRequestCode($requestCode): void
    {
        $this->requestCode = $requestCode;
    }

    /**
     * @return mixed
     */
    public function getTimeSend()
    {
        return $this->Time_Send;
    }

    /**
     * @param mixed $Time_Send
     */
    public function setTimeSend($Time_Send): void
    {
        $this->Time_Send = $Time_Send;
    }

    /**
     * @return mixed
     */
    public function getJTimeSend()
    {
        return $this->JTime_Send;
    }

    /**
     * @param mixed $JTime_Send
     */
    public function setJTimeSend($JTime_Send): void
    {
        $this->JTime_Send = $JTime_Send;
    }

    /**
     * @return mixed
     */
    public function getTimeStart()
    {
        return $this->Time_Start;
    }

    /**
     * @param mixed $Time_Start
     */
    public function setTimeStart($Time_Start): void
    {
        $this->Time_Start = $Time_Start;
    }

    /**
     * @return mixed
     */
    public function getTimeEnd()
    {
        return $this->Time_End;
    }

    /**
     * @param mixed $Time_End
     */
    public function setTimeEnd($Time_End): void
    {
        $this->Time_End = $Time_End;
    }

    /**
     * @return mixed
     */
    public function getSystemName()
    {
        return $this->System_Name;
    }

    /**
     * @param mixed $System_Name
     */
    public function setSystemName($System_Name): void
    {
        $this->System_Name = $System_Name;
    }

    /**
     * @return mixed
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @param mixed $phase
     */
    public function setPhase($phase): void
    {
        $this->phase = $phase;
    }

    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param mixed $section
     */
    public function setSection($section): void
    {
        $this->section = $section;
    }

    /**
     * @return mixed
     */
    public function getLine()
    {
        return $this->Line;
    }

    /**
     * @param mixed $Line
     */
    public function setLine($Line): void
    {
        $this->Line = $Line;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->Cost;
    }

    /**
     * @param mixed $Cost
     */
    public function setCost($Cost): void
    {
        $this->Cost = $Cost;
    }

    /**
     * @return mixed
     */
    public function getWorkerSection()
    {
        return $this->WorkerSection;
    }

    /**
     * @param mixed $WorkerSection
     */
    public function setWorkerSection($WorkerSection): void
    {
        $this->WorkerSection = $WorkerSection;
    }

    /**
     * @return mixed
     */
    public function getOffTime()
    {
        return $this->offTime;
    }

    /**
     * @param mixed $offTime
     */
    public function setOffTime($offTime): void
    {
        $this->offTime = $offTime;
    }

    /**
     * @return mixed
     */
    public function getSystemStatus()
    {
        return $this->System_Status;
    }

    /**
     * @param mixed $System_Status
     */
    public function setSystemStatus($System_Status): void
    {
        $this->System_Status = $System_Status;
    }

    /**
     * @return mixed
     */
    public function getWorkTitle()
    {
        return $this->WorkTitle;
    }

    /**
     * @param mixed $WorkTitle
     */
    public function setWorkTitle($WorkTitle): void
    {
        $this->WorkTitle = $WorkTitle;
    }

    /**
     * @return mixed
     */
    public function getBugInfluence()
    {
        return $this->BugInfluence;
    }

    /**
     * @param mixed $BugInfluence
     */
    public function setBugInfluence($BugInfluence): void
    {
        $this->BugInfluence = $BugInfluence;
    }

    /**
     * @return mixed
     */
    public function getLatency()
    {
        return $this->latency;
    }

    /**
     * @param mixed $latency
     */
    public function setLatency($latency): void
    {
        $this->latency = $latency;
    }

    /**
     * @return mixed
     */
    public function getLatencyTime()
    {
        return $this->latencyTime;
    }

    /**
     * @param mixed $latencyTime
     */
    public function setLatencyTime($latencyTime): void
    {
        $this->latencyTime = $latencyTime;
    }

    /**
     * @return mixed
     */
    public function getFailure()
    {
        return $this->failure;
    }

    /**
     * @param mixed $failure
     */
    public function setFailure($failure): void
    {
        $this->failure = $failure;
    }

    /**
     * @return mixed
     */
    public function getFailureDes()
    {
        return $this->failureDes;
    }

    /**
     * @param mixed $failureDes
     */
    public function setFailureDes($failureDes): void
    {
        $this->failureDes = $failureDes;
    }

    /**
     * @return mixed
     */
    public function getDonework()
    {
        return $this->donework;
    }

    /**
     * @param mixed $donework
     */
    public function setDonework($donework): void
    {
        $this->donework = $donework;
    }

    /**
     * @return mixed
     */
    public function getDoneworkDes()
    {
        return $this->doneworkDes;
    }

    /**
     * @param mixed $doneworkDes
     */
    public function setDoneworkDes($doneworkDes): void
    {
        $this->doneworkDes = $doneworkDes;
    }

    /**
     * @return mixed
     */
    public function getUnitPersonId()
    {
        return $this->unitPerson_id;
    }

    /**
     * @param mixed $unitPerson_id
     */
    public function setUnitPersonId($unitPerson_id): void
    {
        $this->unitPerson_id = $unitPerson_id;
    }

    /**
     * @return mixed
     */
    public function getWorkerPersonId()
    {
        return $this->workerPerson_id;
    }

    /**
     * @param mixed $workerPerson_id
     */
    public function setWorkerPersonId($workerPerson_id): void
    {
        $this->workerPerson_id = $workerPerson_id;
    }

    /**
     * @return mixed
     */
    public function getSenderNote()
    {
        return $this->Sender_note;
    }

    /**
     * @param mixed $Sender_note
     */
    public function setSenderNote($Sender_note): void
    {
        $this->Sender_note = $Sender_note;
    }

    /**
     * @return mixed
     */
    public function getHumanNumber()
    {
        return $this->HumanNumber;
    }

    /**
     * @param mixed $HumanNumber
     */
    public function setHumanNumber($HumanNumber): void
    {
        $this->HumanNumber = $HumanNumber;
    }

    /**
     * @return mixed
     */
    public function getConsumableParts()
    {
        return $this->Consumable_Parts;
    }

    /**
     * @param mixed $Consumable_Parts
     */
    public function setConsumableParts($Consumable_Parts): void
    {
        $this->Consumable_Parts = $Consumable_Parts;
    }

    /**
     * @return mixed
     */
    public function getConsumablePartsQty()
    {
        return $this->Consumable_Parts_Qty;
    }

    /**
     * @param mixed $Consumable_Parts_Qty
     */
    public function setConsumablePartsQty($Consumable_Parts_Qty): void
    {
        $this->Consumable_Parts_Qty = $Consumable_Parts_Qty;
    }

    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'requestService', 'COUNT(requestId) as co')) [0]['co'];
    }

    public function getItemsBySection($section, $sortWith = ['column' => 'Time_Send', 'type' => 'desc'], $pagination = [0, 25])
    {
        $value = array();
        $variable = array();

        $value[] = '%' . $section . '%';
        $variable[] = 'reSer.section Like ?';

        model::join('sections  WorkerSection', 'FIND_IN_SET(WorkerSection.id , reSer.WorkerSection) != 0 ');
        model::join('requestService_BugInfluence BugInfluence', 'FIND_IN_SET(BugInfluence.id , reSer.BugInfluence) != 0');

        $tableName = 'requestService reSer';
        $field = array();
        $field[] = 'requestId';
        $field[] = 'reSer.WorkerSection';
        $field[] = 'GROUP_CONCAT(DISTINCT WorkerSection.label separator ",") as WorkerSectionName';
        $field[] = 'Time_Send';
        $field[] = 'GROUP_CONCAT(DISTINCT BugInfluence.label separator ",")  as BugInfluence';
        $fields = implode(' , ', $field);


        return parent::search($value, (count($variable) == 0) ? null : implode(' and ', $variable), $tableName, $fields, $sortWith, $pagination, 'requestId');
    }

    public function getItemsByWorkerSection($section, $sortWith = ['column' => 'Time_Send', 'type' => 'desc'], $pagination = [0, 25])
    {
        $value = array();
        $value[] = '%' . $section . '%';
        $variable = array();
        $variable[] = 'reSer.WorkerSection Like ?';
        model::join('sections sections', ' sections.id = reSer.section ');
        model::join('requestService_BugInfluence BugInfluence', 'FIND_IN_SET(BugInfluence.id , reSer.BugInfluence) != 0');

        $tableName = 'requestService reSer';
        $field = array();
        $field[] = 'requestId';
        $field[] = 'Time_Send';
        $field[] = 'sections.label as sectionName';
        $field[] = 'GROUP_CONCAT(DISTINCT BugInfluence.label separator ",") as BugInfluence';
        $fields = implode(' , ', $field);


        return parent::search($value, (count($variable) == 0) ? null : implode(' and ', $variable), $tableName, $fields, $sortWith, $pagination, 'requestId');

    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'Time_Send', 'type' => 'desc'], $pagination = [0, 25])
    {
        model::join('sections  WorkerSection', 'FIND_IN_SET(WorkerSection.id , reSer.WorkerSection) != 0 ');
        model::join('requestService_BugInfluence BugInfluence', 'FIND_IN_SET(BugInfluence.id , reSer.BugInfluence) != 0');

        $tableName = 'requestService reSer';
        $field = array();
        $field[] = 'requestId';
        $field[] = 'reSer.WorkerSection';
        $field[] = 'GROUP_CONCAT(DISTINCT WorkerSection.label separator ",") as WorkerSectionName';
        $field[] = 'Time_Send';
        $field[] = 'GROUP_CONCAT(DISTINCT BugInfluence.label separator ",")  as BugInfluence';
        $fields = implode(' , ', $field);

        return parent::search($value, (count($variable) == 0) ? null : implode(' and ', $variable), $tableName, $fields, $sortWith, $pagination, 'requestId');
    }
}
