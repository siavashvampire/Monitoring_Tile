<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class product_brand extends model implements modelInterFace {

    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $label;
    private $agent;


    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->label = $result['label'];
        $this->agent = $result['agent'];
    }

    public function returnAsArray(): array
    {
        $array['id'] = $this->id;
        $array['label'] = $this->label;
        $array['agent'] = $this->agent;
        return $array;
    }

    /**
     * @return array
     */
    public function getPrimaryKey(): array
    {
        return $this->primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate(): string
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label): void
    {
        $this->label = $label;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
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


    public function getCount($value = array(),$variable = array()) {
        return (parent::search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'product_brand item', 'COUNT(item.id) as co' )) [0]['co'];
    }
    public function getItems($value = array(),$variable = array() , $sortWith = ['column' => 'item.label' , 'type' =>'asc'] , $pagination = [1,25]) {
        model::join('user agentUser', 'item.agent = agentUser.userId');
        return parent::search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'product_brand item', 'item.id ,item.label,item.agent as agent,concat(agentUser.fname," ",agentUser.lname) as agentUser '  , $sortWith ,$pagination);
    }

    public function getByUsersId($id){
        $value = array();
        $value[] = $id;
        $variable = array();
        $variable[] = 'item.agent = ?';
        return parent::search(  $value  ,  implode(' and ' , $variable)  , 'product_brand item', 'item.id ,item.label' );
    }
}
