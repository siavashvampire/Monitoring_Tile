<?php

namespace App\contract\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace;

class evaluation_type extends model implements modelInterFace
{

    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $Name;
    private $evaluatedGroup;
    private $evaluatorGroup;
    private $checkByUnit;
    private $ShowToReceiver;

    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->Name = $result['Name'];
        $this->evaluatedGroup = $result['evaluatedGroup'];
        $this->evaluatorGroup = $result['evaluatorGroup'];
        $this->checkByUnit = $result['checkByUnit'];
        $this->ShowToReceiver = $result['ShowToReceiver'];
    }

    public function returnAsArray()
    {
        $array['id'] = $this->id;
        $array['Name'] = $this->Name;
        $array['evaluatedGroup'] = $this->evaluatedGroup;
        $array['evaluatorGroup'] = $this->evaluatorGroup;
        $array['checkByUnit'] = $this->checkByUnit;
        $array['ShowToReceiver'] = $this->ShowToReceiver;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getEvaluatedGroup()
    {
        return $this->evaluatedGroup;
    }

    /**
     * @param mixed $evaluatedGroup
     */
    public function setEvaluatedGroup($evaluatedGroup)
    {
        $this->evaluatedGroup = $evaluatedGroup;
    }

    /**
     * @return mixed
     */
    public function getEvaluatorGroup()
    {
        return $this->evaluatorGroup;
    }

    /**
     * @param mixed $evaluatorGroup
     */
    public function setEvaluatorGroup($evaluatorGroup)
    {
        $this->evaluatorGroup = $evaluatorGroup;
    }

    /**
     * @return mixed
     */
    public function getCheckByUnit()
    {
        return $this->checkByUnit;
    }

    /**
     * @param mixed $checkByUnit
     */
    public function setCheckByUnit($checkByUnit)
    {
        $this->checkByUnit = $checkByUnit;
    }

    /**
     * @return mixed
     */
    public function getShowToReceiver()
    {
        return $this->ShowToReceiver;
    }

    /**
     * @param mixed $ShowToReceiver
     */
    public function setShowToReceiver($ShowToReceiver)
    {
        $this->ShowToReceiver = $ShowToReceiver;
    }

    public function getEvaluationTypeById($id = array())
    {
        if (count($id))
            return (parent::search([1], '? AND id IN (' . implode(',', $id) . ')', 'evaluation_type evaluation_type', 'id,Name'));
        else
            return true;
    }

    public function getEvaluationTypeByUserGroupId($GroupId,$Admin=0)
    {
        if ($GroupId == $Admin){
            return (parent::search([1], '?', 'evaluation_type type', 'id,Name'));
        }
        return (parent::search([$GroupId], 'type.evaluatorGroup = ?', 'evaluation_type type', 'id,Name'));

    }

}
