<?php
namespace App\contacts\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class Phone_type extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;


	public function setFromArray($result) {
		$this->id                  = $result['id'] ;
		$this->label                = $result['Name'] ;
	}

	public function returnAsArray( ) {
		$array['id']             = $this->id ;
		$array['label']           = $this->label ;

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

    public function getType()
    {
        return parent::search([], null, 'Phone_type', '*');
    }

}
