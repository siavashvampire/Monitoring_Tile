<?php
namespace App\weighbridge\model;

use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class products extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
    private $label;
    private $weight_loss;
	private $unit ;
	private $description ;
	private $standard ;
	private $amount ;
	private $mass ;
	private $massInReceipt ;
	private $unit_price_sale ;
	private $previous_price_sale ;
	private $Time_Send_sale ;
	private $previous_Time_Send_sale ;
	private $unit_price_buy ;
	private $previous_price_buy ;
	private $Time_Send_buy;
	private $previous_Time_Send_buy;


	public function setFromArray($result) {
		$this->id                    = $result['id'] ;
		$this->label                 = $result['label'] ;
		$this->weight_loss           = $result['weight_loss'] ;
		$this->unit                  = $result['unit'] ;
		$this->description           = $result['description'] ;
		$this->standard              = $result['standard'] ;
		$this->amount                = $result['amount'] ;
		$this->mass                  = $result['mass'] ;
		$this->massInReceipt         = $result['massInReceipt'] ;
		$this->unit_price_sale       = $result['unit_price_sale'] ;
		$this->previous_price_sale   = $result['previous_price_sale'] ;
		$this->Time_Send_sale        = $result['Time_Send_sale'] ;
		$this->previous_Time_Send_sale        = $result['previous_Time_Send_sale'] ;
		$this->unit_price_buy        = $result['unit_price_buy'] ;
		$this->previous_price_buy        = $result['previous_price_buy'] ;
		$this->Time_Send_buy        = $result['Time_Send_buy'] ;
		$this->previous_Time_Send_buy        = $result['previous_Time_Send_buy'] ;

	}

	public function returnAsArray( ) {
		$array['id']                = $this->id ;
		$array['label']             = $this->label ;
		$array['weight_loss']       = $this->weight_loss ;
		$array['unit']              = $this->unit ;
		$array['description']       = $this->description ;
		$array['standard']          = $this->standard ;
		$array['amount']            = $this->amount ;
		$array['mass']              = $this->mass ;
		$array['massInReceipt']     = $this->massInReceipt ;
		$array['unit_price_sale']   = $this->unit_price_sale ;
		$array['previous_price_sale']   = $this->previous_price_sale ;
		$array['Time_Send_sale']   = $this->Time_Send_sale ;
		$array['previous_Time_Send_sale']   = $this->previous_Time_Send_sale ;
		$array['unit_price_buy']   = $this->unit_price_buy ;
		$array['previous_price_buy']   = $this->previous_price_buy ;
		$array['Time_Send_buy']   = $this->Time_Send_buy ;
		$array['previous_Time_Send_buy']   = $this->previous_Time_Send_buy ;

		return $array ;
	}

    /**
     * @return string[]
     */
    public function getPrimaryKey(): array
    {
        return $this->primaryKey;
    }

    /**
     * @param string[] $primaryKey
     */
    public function setPrimaryKey(array $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate(): string
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
    }

    /**
     * @param string $primaryKeyShouldNotInsertOrUpdate
     */
    public function setPrimaryKeyShouldNotInsertOrUpdate(string $primaryKeyShouldNotInsertOrUpdate): void
    {
        $this->primaryKeyShouldNotInsertOrUpdate = $primaryKeyShouldNotInsertOrUpdate;
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
    public function getWeightLoss()
    {
        return $this->weight_loss;
    }

    /**
     * @param mixed $weight_loss
     */
    public function setWeightLoss($weight_loss): void
    {
        $this->weight_loss = $weight_loss;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param mixed $unit
     */
    public function setUnit($unit): void
    {
        $this->unit = $unit;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getStandard()
    {
        return $this->standard;
    }

    /**
     * @param mixed $standard
     */
    public function setStandard($standard): void
    {
        $this->standard = $standard;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getMass()
    {
        return $this->mass;
    }

    /**
     * @param mixed $mass
     */
    public function setMass($mass): void
    {
        $this->mass = $mass;
    }

    /**
     * @return mixed
     */
    public function getMassInReceipt()
    {
        return $this->massInReceipt;
    }

    /**
     * @param mixed $massInReceipt
     */
    public function setMassInReceipt($massInReceipt): void
    {
        $this->massInReceipt = $massInReceipt;
    }

    /**
     * @return mixed
     */
    public function getUnitPriceSale()
    {
        return $this->unit_price_sale;
    }

    /**
     * @param mixed $unit_price_sale
     */
    public function setUnitPriceSale($unit_price_sale): void
    {
        $this->unit_price_sale = $unit_price_sale;
    }

    /**
     * @return mixed
     */
    public function getPreviousPriceSale()
    {
        return $this->previous_price_sale;
    }

    /**
     * @param mixed $previous_price_sale
     */
    public function setPreviousPriceSale($previous_price_sale): void
    {
        $this->previous_price_sale = $previous_price_sale;
    }

    /**
     * @return mixed
     */
    public function getTimeSendSale()
    {
        return $this->Time_Send_sale;
    }

    /**
     * @param mixed $Time_Send_sale
     */
    public function setTimeSendSale($Time_Send_sale): void
    {
        $this->Time_Send_sale = $Time_Send_sale;
    }

    /**
     * @return mixed
     */
    public function getPreviousTimeSendSale()
    {
        return $this->previous_Time_Send_sale;
    }

    /**
     * @param mixed $previous_Time_Send_sale
     */
    public function setPreviousTimeSendSale($previous_Time_Send_sale): void
    {
        $this->previous_Time_Send_sale = $previous_Time_Send_sale;
    }

    /**
     * @return mixed
     */
    public function getUnitPriceBuy()
    {
        return $this->unit_price_buy;
    }

    /**
     * @param mixed $unit_price_buy
     */
    public function setUnitPriceBuy($unit_price_buy): void
    {
        $this->unit_price_buy = $unit_price_buy;
    }

    /**
     * @return mixed
     */
    public function getPreviousPriceBuy()
    {
        return $this->previous_price_buy;
    }

    /**
     * @param mixed $previous_price_buy
     */
    public function setPreviousPriceBuy($previous_price_buy): void
    {
        $this->previous_price_buy = $previous_price_buy;
    }

    /**
     * @return mixed
     */
    public function getTimeSendBuy()
    {
        return $this->Time_Send_buy;
    }

    /**
     * @param mixed $Time_Send_buy
     */
    public function setTimeSendBuy($Time_Send_buy): void
    {
        $this->Time_Send_buy = $Time_Send_buy;
    }

    /**
     * @return mixed
     */
    public function getPreviousTimeSendBuy()
    {
        return $this->previous_Time_Send_buy;
    }

    /**
     * @param mixed $previous_Time_Send_buy
     */
    public function setPreviousTimeSendBuy($previous_Time_Send_buy): void
    {
        $this->previous_Time_Send_buy = $previous_Time_Send_buy;
    }


    public function getItemCount($value = array(),$variable = array()) {
        return (parent::search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'payments item', 'COUNT(item.id) as co' )) [0]['co'];
    }
    public function getItems($value = array(),$variable = array() , $sortWith = ['column' => 'id' , 'type' =>'asc'],$pagination = ['start' => 0 , 'limit' =>"25"]) {
	    return parent::search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'payments item' , 'item.*'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
	}
}
