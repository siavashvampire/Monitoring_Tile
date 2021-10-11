<?php
namespace App\DAUnits\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class DAUnits_Type extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;
	private $testPort ;



	public function setFromArray($result) {
		$this->id            = $result['id'] ;
		$this->label            = $result['label'] ;
		$this->testPort            = $result['testPort'] ;
	}

	public function returnAsArray( ) {
		$array['id']         = $this->id ;
		$array['label']         = $this->label ;
		$array['testPort']         = $this->testPort ;

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
    public function setPrimaryKey(array $primaryKey)
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
    public function setPrimaryKeyShouldNotInsertOrUpdate(string $primaryKeyShouldNotInsertOrUpdate)
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
    public function setId($id)
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
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getTestPort()
    {
        return $this->testPort;
    }

    /**
     * @param mixed $testPort
     */
    public function setTestPort($testPort)
    {
        $this->testPort = $testPort;
    }
    public function getType()
    {
        return parent::search([], null, 'DAUnits_Type', '*');
    }


}
