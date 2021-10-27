<?php
namespace App\weighbridge\model;

use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class payments extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
    private $Time_Send;
    private $JTime_Send;
	private $customer ;
	private $account_status ;
	private $operation_type ;
	private $amount ;
	private $description ;
	private $payment_method ;
	private $receipt_number ;
	private $user ;


	public function setFromArray($result) {
		$this->id                   = $result['id'] ;
		$this->Time_Send            = $result['Time_Send'] ;
		$this->JTime_Send           = $result['JTime_Send'] ;
		$this->customer             = $result['customer'] ;
		$this->account_status       = $result['account_status'] ;
		$this->operation_type       = $result['operation_type'] ;
		$this->amount               = $result['amount'] ;
		$this->description          = $result['description'] ;
		$this->payment_method       = $result['payment_method'] ;
		$this->receipt_number       = $result['receipt_number'] ;
		$this->user                 = $result['user'] ;

	}

	public function returnAsArray( ) {
		$array['id']                = $this->id ;
		$array['registrar']         = $this->registrar ;
		$array['registerTime']      = $this->registerTime ;
		$array['Time_Send']         = $this->Time_Send ;
		$array['JTime_Send']        = $this->JTime_Send ;
		$array['customer']          = $this->customer ;
		$array['account_status']    = $this->account_status ;
		$array['operation_type']    = $this->operation_type ;
		$array['amount']            = $this->amount ;
		$array['description']       = $this->description ;
		$array['payment_method']    = $this->payment_method ;
		$array['receipt_number']    = $this->receipt_number ;
		$array['user']              = $this->user ;

		return $array ;
	}

	/**
	 * @return array
	 */
	public function getPrimaryKey() {
		return $this->primaryKey;
	}

	/**
	 * @return string
	 */
	public function getPrimaryKeyShouldNotInsertOrUpdate() {
		return $this->primaryKeyShouldNotInsertOrUpdate;
	}

    	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
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
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getAccountStatus()
    {
        return $this->account_status;
    }

    /**
     * @param mixed $account_status
     */
    public function setAccountStatus($account_status): void
    {
        $this->account_status = $account_status;
    }

    /**
     * @return mixed
     */
    public function getOperationType()
    {
        return $this->operation_type;
    }

    /**
     * @param mixed $operation_type
     */
    public function setOperationType($operation_type): void
    {
        $this->operation_type = $operation_type;
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
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * @param mixed $payment_method
     */
    public function setPaymentMethod($payment_method): void
    {
        $this->payment_method = $payment_method;
    }

    /**
     * @return mixed
     */
    public function getReceiptNumber()
    {
        return $this->receipt_number;
    }

    /**
     * @param mixed $receipt_number
     */
    public function setReceiptNumber($receipt_number): void
    {
        $this->receipt_number = $receipt_number;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }


    public function getItemCount($value = array(),$variable = array()) {
        return (parent::search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'payments item', 'COUNT(item.id) as co' )) [0]['co'];
    }
    public function getItems($value = array(),$variable = array() , $sortWith = ['column' => 'id' , 'type' =>'asc'],$pagination = ['start' => 0 , 'limit' =>"25"]) {
	    return parent::search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'payments item' , 'item.*'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
	}
}
