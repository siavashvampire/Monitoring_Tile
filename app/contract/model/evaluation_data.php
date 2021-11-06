<?php

namespace App\contract\model;

use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class evaluation_data extends model implements modelInterFace
{
    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $type;
    private $createDate;
    private $confirmDate;
    private $fillOutDate;
    private $evaluated;
    private $evaluator;
    private $creator;
    private $finished;

    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->type = $result['type'];
        $this->createDate = $result['createDate'];
        $this->confirmDate = $result['confirmDate'];
        $this->fillOutDate = $result['fillOutDate'];
        $this->evaluated = $result['evaluated'];
        $this->evaluator = $result['evaluator'];
        $this->creator = $result['creator'];
        $this->finished = $result['finished'];
    }

    public function returnAsArray(): array
    {
        $array['id'] = $this->id;
        $array['type'] = $this->type;
        $array['createDate'] = $this->createDate;
        $array['confirmDate'] = $this->confirmDate;
        $array['fillOutDate'] = $this->fillOutDate;
        $array['evaluated'] = $this->evaluated;
        $array['evaluator'] = $this->evaluator;
        $array['creator'] = $this->creator;
        $array['finished'] = $this->finished;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param mixed $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * @return mixed
     */
    public function getConfirmDate()
    {
        return $this->confirmDate;
    }

    /**
     * @param mixed $confirmDate
     */
    public function setConfirmDate($confirmDate)
    {
        $this->confirmDate = $confirmDate;
    }

    /**
     * @return mixed
     */
    public function getFillOutDate()
    {
        return $this->fillOutDate;
    }

    /**
     * @param mixed $fillOutDate
     */
    public function setFillOutDate($fillOutDate)
    {
        $this->fillOutDate = $fillOutDate;
    }

    /**
     * @return mixed
     */
    public function getEvaluated()
    {
        return $this->evaluated;
    }

    /**
     * @return array|bool|null
     */
    public function getEvaluatedPerson()
    {
        return parent::search([$this->evaluated], "userId = ?", 'user', '*', ['column' => 'userId', 'type' => 'asc']);
    }

    /**
     * @param mixed $evaluated
     */
    public function setEvaluated($evaluated)
    {
        $this->evaluated = $evaluated;
    }

    /**
     * @return mixed
     */
    public function getEvaluator()
    {
        return $this->evaluator;
    }

    /**
     * @param mixed $evaluator
     */
    public function setEvaluator($evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * @return mixed
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param mixed $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return mixed
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * @param mixed $finished
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;
    }

    public function getEvaluationListWithoutExtra($userAdmin, $group_id, $value = array(), $variable = array())
    {
        $order = array();
        $order[] = ['column' => 'evaluation_data.confirmDate', 'type' => 'DESC'];
        $order[] = ['column' => 'evaluation_data.type', 'type' => 'asc'];
        $order[] = ['column' => 'userEvaluated.lname', 'type' => 'asc'];

        $field = array();
        $field[] = 'userEvaluated.fname';
        $field[] = 'userEvaluated.lname';
        $field[] = 'userEvaluator.fname as evaluator_fname';
        $field[] = 'userEvaluator.lname as evaluator_lname';
        $field[] = 'type.evaluatedGroup as EvaluatedGroup';
        $field[] = 'type.evaluatorGroup';
        $field[] = 'evaluation_data.evaluator';
        $field[] = 'user_groupEvaluated.name as groupName';
        $field[] = 'evaluation_data.id';
        $field[] = 'DATE_FORMAT(jdate(evaluation_data.confirmDate), "%Y-%m-%d") AS confirmDate';
        $field[] = 'evaluation_data.finished';
        $field[] = 'evaluation_data.type,type.Name as typeName';

        model::join('user userEvaluated', 'evaluation_data.evaluated =  userEvaluated.userId');
        model::join('user userEvaluator', 'evaluation_data.evaluator =  userEvaluator.userId');
        model::join('user userCreator', 'evaluation_data.creator =  userCreator.userId');
        model::join('user_group user_groupEvaluated', 'user_groupEvaluated.user_groupId =  userEvaluated.user_group_id');
        model::join('evaluation_type type', 'type.id =  evaluation_data.type');
        if ($userAdmin != $group_id) {
            $value[] = $group_id;
            $variable[] = 'type.evaluatorGroup = ?';
        }
        $temp = parent::search($value, (count($variable) == 0) ? null : implode(' and ', $variable), 'evaluation_data evaluation_data', implode(',', $field), $order);
        if ($temp === true)
            $temp = array();
        return ($temp);
    }

    public function getExtraEvaluationList($user_id, $group_id, $value = array(), $variable = array())
    {
        $order = array();
        $order[] = ['column' => 'evaluation_data.confirmDate', 'type' => 'DESC'];
        $order[] = ['column' => 'evaluation_data.type', 'type' => 'asc'];
        $order[] = ['column' => 'userEvaluated.lname', 'type' => 'asc'];

        $groupBy = array();
        $groupBy[] = 'evaluation_data.type';
        $groupBy[] = 'evaluation_data.createDate';
        $groupBy[] = 'evaluation_data.evaluated';

        $field = array();
        $field[] = 'MAX(IF(evaluation_data.evaluator = ' . $user_id . ', 2, 1)) AS choose';
        $field[] = 'userEvaluated.fname';
        $field[] = 'userEvaluated.lname';
        $field[] = 'userEvaluator.fname as evaluator_fname';
        $field[] = 'userEvaluator.lname as evaluator_lname';
        $field[] = 'type.evaluatedGroup as EvaluatedGroup';
        $field[] = 'type.evaluatorGroup';
        $field[] = 'evaluation_data.evaluator';
        $field[] = 'user_groupEvaluated.name as groupName';
        $field[] = 'evaluation_data.id as semiId';
        $field[] = 'null as id';
        $field[] = 'DATE_FORMAT(jdate(evaluation_data.confirmDate), "%Y-%m-%d") AS confirmDate';
        $field[] = '0 as finished';
        $field[] = 'evaluation_data.type,type.Name as typeName';

        model::join('user userEvaluated', 'evaluation_data.evaluated =  userEvaluated.userId');
        model::join('user userEvaluator', 'evaluation_data.evaluator =  userEvaluator.userId');
        model::join('user userCreator', 'evaluation_data.creator =  userCreator.userId');
        model::join('user_group user_groupEvaluated', 'user_groupEvaluated.user_groupId =  userEvaluated.user_group_id');
        model::join('evaluation_type type', 'type.id =  evaluation_data.type');

        $value[] = $group_id;
        $variable[] = 'type.evaluatorGroup = ?';
        $variable[] = 'evaluation_data.evaluator IS NOT NULL';
//        $variable[] = 'evaluation_data.finished = 1';

        $tempData = parent::search($value, (count($variable) == 0) ? null : implode(' and ', $variable), 'evaluation_data evaluation_data', implode(',', $field), $order, null, implode(',', $groupBy));

        if (!(is_array($tempData)))
            $tempData = array();

        foreach ($tempData as $index => $OneData)
            if ($OneData['choose'] == 2)
                unset($tempData[$index]);

        return $tempData;
    }

    public function getEvaluationList($user_id, $group_id, $userAdmin, $sort, $sortRest, $value = array(), $variable = array(), $finished = array())
    {
        $finish = 0;
        $notFinish = 0;
        if ($finished != "") {
            foreach ($finished as $item) {
                if ($item == 1)
                    $finish = 1;
                if ($item == 0)
                    $notFinish = 1;
            }
        } else {
            $finish = 1;
            $notFinish = 1;
        }
        if ($user_id == null)
            return array();
        $eval = self::getEvaluationListWithoutExtra($userAdmin, $group_id, $value, $variable);

        if ($notFinish != 0)
            $evalExtra = self::getExtraEvaluationList($user_id, $group_id, $value, $variable);
        else
            $evalExtra = array();

        $eval = (array_merge($eval, $evalExtra));

        $sortColumn = array();
        foreach ($sort as $index => $OneData) {
            $sortColumn[] = array_column($eval, $OneData);
            $sortColumn[] = $sortRest[$index];
        }
        $sortColumn[] = $eval;

        array_multisort(...$sortColumn);
        $eval = end($sortColumn);

        foreach ($eval as $index => $OneData) {
            if ($OneData['finished'] == 1 and $finish == 0)
                unset($eval[$index]);
            if ($OneData['finished'] == 0 and $notFinish == 0)
                unset($eval[$index]);
        }
        if (count($eval) == 0)
            $eval = null;
        return $eval;
    }
}
