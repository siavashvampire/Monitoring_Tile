<?php


namespace App\requestService\model;


use App\requestService\app_provider\api\request_service;
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
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'requestService item', 'COUNT(item.requestId) as co')) [0]['co'];
    }

    public function getItemsBySection($section, $sortWith = ['column' => 'Time_Send', 'type' => 'desc'], $pagination = [0, 25])
    {
        $value = array();
        $variable = array();

        $value[] = '%' . $section . '%';
        $variable[] = 'item.section Like ?';

        return self::getItems($value, $variable, $sortWith, $pagination);
    }

    public function getItemsByWorkerSection($section,$value= array(),$variable= array(), $sortWith = ['column' => 'Time_Send', 'type' => 'desc'], $pagination = [0, 25])
    {
        $value[] = '%' . $section . '%';
        $variable[] = 'item.WorkerSection Like ?';

        return self::getItems($value, $variable, $sortWith, $pagination);
    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'item.Time_Send', 'type' => 'desc'], $pagination = [0, 25])
    {
        parent::join('sections  senderSection', 'FIND_IN_SET(senderSection.id , item.section) != 0 ');
        parent::join('sections  WorkerSection', 'FIND_IN_SET(WorkerSection.id , item.WorkerSection) != 0 ');
        parent::join('requestService_BugInfluence BugInfluence', 'FIND_IN_SET(BugInfluence.id , item.BugInfluence) != 0');

        $tableName = 'requestService item';
        $field = array();
        $field[] = 'item.requestId';
        $field[] = 'item.section';
        $field[] = 'GROUP_CONCAT(DISTINCT senderSection.label separator ",") as senderSectionName';
        $field[] = 'item.WorkerSection';
        $field[] = 'GROUP_CONCAT(DISTINCT WorkerSection.label separator ",") as WorkerSectionName';
        $field[] = 'item.Sender_note';
        $field[] = 'item.Time_Send';
        $field[] = 'GROUP_CONCAT(DISTINCT BugInfluence.label separator ",")  as BugInfluence';
        $fields = implode(' , ', $field);
        return parent::search($value, (count($variable) == 0) ? null : implode(' and ', $variable), $tableName, $fields, $sortWith, $pagination, 'item.requestId');
    }

    public function getDayExport($value, $variable)
    {
        $header = [
            'تاریخ درخواست',
            'شماره درخواست',
            'ساعت درخواست',
            'واحد درخواست کننده',
            'فاز',
            'نام دستگاه/تجهیز',
            'حالت تعمیرات',
            'مدت توقف',
            'واحد مجری',
            'ساعت شروع',
            'ساعت اتمام',
            'زمان کارکرد(دقیقه)',
            'شرح خرابی و عملیات انجام شده',
            'نفر کارکرد',
            'نفر ساعت',
        ];

        $requestservice_worktitles = request_service::worktitle() ["result"];
        if (is_array($requestservice_worktitles)) {
            for ($i = 0; $i < count($requestservice_worktitles); $i++) {
                $header[] = $requestservice_worktitles[$i]['label'];
            }
        }

        model::join('sections units', 'units.id = rs.section ');
        model::join('sections unitsWorker', 'unitsWorker.id = rs.WorkerSection ');
        model::join('requestservice_system_status system_status', 'system_status.id = rs.System_Status ');
        model::join('phases phase', 'phase.id = rs.phase');

        $search = parent::search($value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'requestservice' . ' rs', 'rs.JTime_Send ,rs.requestCode ,DATE_FORMAT(rs.Time_Send,\'%H:%i:%s\') as Time_Send_jt ,units.label as senderUnitName  ,phase.label as phase ,rs.System_Name ,system_status.label as systemStatus ,rs.offTime , unitsWorker.label as workerUnitName , DATE_FORMAT(rs.Time_Start,\'%H:%i:%s\') as Time_start_jt , DATE_FORMAT(rs.Time_End,\'%H:%i:%s\') as Time_end_jt , TIMESTAMPDIFF(MINUTE,rs.Time_Start,rs.Time_End) as workTime ,rs.Sender_note ,rs.HumanNumber , rs.HumanNumber * TIMESTAMPDIFF(MINUTE,rs.Time_Start,rs.Time_End) as workTime2 , rs.WorkTitle as WorkTitle');
        if (is_array($search) and count($search) > 0) {
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header("Content-Disposition: attachment; filename=" . 'Export Log (' . date('Y-M-d H:i:s') . ').csv');
            header("Pragma: no-cache");
            header("Expires: 0");
            header('Content-Transfer-Encoding: binary');


            $fp = fopen('php://output', 'w');
            fputcsv($fp, $header);
            for ($i = 0; $i < count($search); $i++) {
                $WorkTitle = $search[$i]['WorkTitle'];
                unset($search[$i]['WorkTitle']);
                if (is_array($requestservice_worktitles)) {
                    for ($i2 = 0; $i2 < count($requestservice_worktitles); $i2++) {
                        if (strpos($WorkTitle, strval($requestservice_worktitles[$i2]['id']))) {
                            $search[$i][] = "1";
                        } else
                            $search[$i][] = "";
                    }
                }
                fputcsv($fp, $search[$i]);
            }
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }

    public function getMonthExportCSV($value, $variable, $header,$showField = '*')
    {
        $search = self::getMonthExportData($value,$variable,$showField)['data'];

        if (is_array($search) and count($search) > 0) {
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header("Content-Disposition: attachment; filename=" . 'Export Log (' . date('Y-M-d H:i:s') . ').csv');
            header("Pragma: no-cache");
            header("Expires: 0");
            header('Content-Transfer-Encoding: binary');

            $fp = fopen('php://output', 'w');
            fputcsv($fp, $header);
            for ($i = 0; $i < count($search); $i++) {
                fputcsv($fp, array_merge([$i + 1], $search[$i]));
            }
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }


    public function getMonthExportData($value, $variable, $showField = '*')
    {
        $showField = implode(' , ', $showField);
        $db = (model::db());
        $perfix = $db::$prefix;
        model::queryUnpreparedWithWhere('CREATE TEMPORARY TABLE IF NOT EXISTS ' . $perfix . 'request_temp_table0 SELECT * FROM ' . $perfix . 'requestservice rs', $value, $variable);
        model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS ' . $perfix . 'request_temp_table1 SELECT SUM(TIMESTAMPDIFF(MINUTE,`Time_Start`,`Time_End`) * `HumanNumber`) as time_diff_all FROM ' . $perfix . 'request_temp_table0;');
        model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS ' . $perfix . 'request_temp_table2 SELECT (SELECT time_diff_all FROM ' . $perfix . 'request_temp_table1) as time_diff_all ,SUM(TIMESTAMPDIFF(MINUTE,data.`Time_Start`,data.`Time_End`) * data.`HumanNumber`) as time_diff,data.phase,data.section,data.WorkerSection FROM ' . $perfix . 'request_temp_table0 data WHERE 1 GROUP by data.section,data.WorkerSection,data.phase;');
        model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS ' . $perfix . 'request_temp_table3 SELECT sections.label as section,workerSections.label as workerSections,phases.label as phase, ROUND(data.time_diff / data.time_diff_all * 100 , 2 ) as percent from ' . $perfix . 'request_temp_table2 data LEFT JOIN ' . $perfix . 'phases phases on phases.id = data.phase LEFT JOIN ' . $perfix . 'sections sections on sections.id = data.section LEFT JOIN ' . $perfix . 'sections workerSections on workerSections.id = data.WorkerSection;');
        $data = parent::search(null, null, 'request_temp_table3', $showField, ['column' => 'percent', 'type' => 'DESC']);
        $time_diff_all = round(parent::search(null, null, 'request_temp_table1')[0]["time_diff_all"]/60,2);
        $count_all = parent::search(null, null, 'request_temp_table0 item', 'COUNT(item.requestId) as co') [0]['co'];
        return ['data' => $data, 'time_diff_all' => $time_diff_all, 'count_all' => $count_all];
    }
}
