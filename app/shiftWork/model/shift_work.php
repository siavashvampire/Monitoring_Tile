<?php


namespace App\shiftWork\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class shift_work extends model implements modelInterFace
{

    private $primaryKey = ['shift_id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'shift_id';
    private $shift_id;
    private $shift_name;
    private $taskmaster_id;

    public function setFromArray($result)
    {
        $this->shift_id = $result['shift_id'];
        $this->shift_name = $result['shift_name'];
        $this->taskmaster_id = $result['taskmaster_id'];
    }

    public function returnAsArray()
    {
        $array['shift_id'] = $this->shift_id;
        $array['shift_name'] = $this->shift_name;
        $array['taskmaster_id'] = $this->taskmaster_id;
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
    public function getShiftId()
    {
        return $this->shift_id;
    }

    /**
     * @param mixed $shift_id
     */
    public function setShiftId($shift_id)
    {
        $this->shift_id = $shift_id;
    }

    /**
     * @return mixed
     */
    public function getShiftName()
    {
        return $this->shift_name;
    }

    /**
     * @param mixed $shift_name
     */
    public function setShiftName($shift_name)
    {
        $this->shift_name = $shift_name;
    }

    /**
     * @return mixed
     */
    public function getTaskmasterId()
    {
        return $this->taskmaster_id;
    }

    /**
     * @param mixed $taskmaster_id
     */
    public function setTaskmasterId($taskmaster_id)
    {
        $this->taskmaster_id = $taskmaster_id;
    }

    public function getShiftWork()
    {
        return parent::search([-1], 'shift_id <> ?', 'shift_work', '*', ['column' => 'shift_id', 'type' => 'asc']);
    }

}
