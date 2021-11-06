<?php

namespace App\post_design\model;

use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class post_data extends model implements modelInterFace
{
    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $type;
    private $agent;
    private $createDate;
    private $fillOutDate;
    private $creator;
    private $finished;

    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->type = $result['type'];
        $this->agent = $result['agent'];
        $this->createDate = $result['createDate'];
        $this->fillOutDate = $result['fillOutDate'];
        $this->creator = $result['creator'];
        $this->finished = $result['finished'];
    }

    public function returnAsArray(): array
    {
        $array['id'] = $this->id;
        $array['type'] = $this->type;
        $array['agent'] = $this->agent;
        $array['createDate'] = $this->createDate;
        $array['fillOutDate'] = $this->fillOutDate;
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
    public function setId($id): void
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
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param mixed $agent
     */
    public function setAgent($agent): void
    {
        $this->agent = $agent;
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
    public function setCreateDate($createDate): void
    {
        $this->createDate = $createDate;
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
    public function setFillOutDate($fillOutDate): void
    {
        $this->fillOutDate = $fillOutDate;
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
    public function setCreator($creator): void
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
    public function setFinished($finished): void
    {
        $this->finished = $finished;
    }


    /**
     * @return array|bool|null
     */
    public function getEvaluatedPerson()
    {
        return parent::search([$this->agent], "userId = ?", 'user', '*', ['column' => 'userId', 'type' => 'asc']);
    }

    public function getEvaluationListWithoutExtra($userAdmin, $group_id, $value = array(), $variable = array())
    {
        $order = array();
        $order[] = ['column' => 'post_data.createDate', 'type' => 'DESC'];
        $order[] = ['column' => 'post_data.type', 'type' => 'asc'];
        $order[] = ['column' => 'userAgent.lname', 'type' => 'asc'];

        $field = array();
        $field[] = 'userAgent.fname';
        $field[] = 'userAgent.lname';
        $field[] = 'type.evaluatedGroup as EvaluatedGroup';
        $field[] = 'type.evaluatorGroup';
        $field[] = 'post_data.agent';
        $field[] = 'user_groupEvaluated.name as groupName';
        $field[] = 'post_data.id';
        $field[] = 'DATE_FORMAT(jdate(post_data.createDate), "%Y-%m-%d") AS createDate';
        $field[] = 'post_data.finished';
        $field[] = 'post_data.type,type.Name as typeName';

        model::join('user userAgent', 'post_data.agent =  userAgent.userId');
        model::join('user userCreator', 'post_data.creator =  userCreator.userId');
        model::join('user_group user_groupEvaluated', 'user_groupEvaluated.user_groupId =  userAgent.user_group_id');
        model::join('post_type type', 'type.id =  post_data.type');
        if ($userAdmin != $group_id and 0) {
            $value[] = $group_id;
            $variable[] = 'type.evaluatorGroup = ?';
        }
        $temp = parent::search($value, (count($variable) == 0) ? null : implode(' and ', $variable), 'post_data post_data', implode(',', $field), $order);
        if ($temp === true)
            $temp = array();
        return ($temp);
    }

    public function getExtraEvaluationList($user_id, $group_id, $value = array(), $variable = array())
    {
        $order = array();
        $order[] = ['column' => 'post_data.confirmDate', 'type' => 'DESC'];
        $order[] = ['column' => 'post_data.type', 'type' => 'asc'];
        $order[] = ['column' => 'userAgent.lname', 'type' => 'asc'];

        $groupBy = array();
        $groupBy[] = 'post_data.type';
        $groupBy[] = 'post_data.createDate';
        $groupBy[] = 'post_data.evaluated';

        $field = array();
        $field[] = 'MAX(IF(post_data.evaluator = ' . $user_id . ', 2, 1)) AS choose';
        $field[] = 'userAgent.fname';
        $field[] = 'userAgent.lname';
        $field[] = 'userEvaluator.fname as evaluator_fname';
        $field[] = 'userEvaluator.lname as evaluator_lname';
        $field[] = 'type.evaluatedGroup as EvaluatedGroup';
        $field[] = 'type.evaluatorGroup';
        $field[] = 'post_data.evaluator';
        $field[] = 'user_groupEvaluated.name as groupName';
        $field[] = 'post_data.id as semiId';
        $field[] = 'null as id';
        $field[] = 'DATE_FORMAT(jdate(post_data.confirmDate), "%Y-%m-%d") AS confirmDate';
        $field[] = '0 as finished';
        $field[] = 'post_data.type,type.Name as typeName';

        model::join('user userAgent', 'post_data.evaluated =  userAgent.userId');
        model::join('user userEvaluator', 'post_data.evaluator =  userEvaluator.userId');
        model::join('user userCreator', 'post_data.creator =  userCreator.userId');
        model::join('user_group user_groupEvaluated', 'user_groupEvaluated.user_groupId =  userAgent.user_group_id');
        model::join('post_type type', 'type.id =  post_data.type');

        $value[] = $group_id;
        $variable[] = 'type.evaluatorGroup = ?';
        $variable[] = 'post_data.evaluator IS NOT NULL';
//        $variable[] = 'post_data.finished = 1';

        $tempData = parent::search($value, (count($variable) == 0) ? null : implode(' and ', $variable), 'post_data post_data', implode(',', $field), $order, null, implode(',', $groupBy));

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

        if (count($eval) == 0)
            $eval = null;
        return $eval;
    }
}
