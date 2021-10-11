<?php


namespace App\contract\model;
// *************************************************************************
// *                                                                       *
// * TableClass - The Complete Table To Class PHP Function                 *
// * Copyright (c) Erfan Ebrahimi. All Rights Reserved,                    *
// * BuildId: 1                                                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * website: https://paymentcms.ir - https://erfanebrahimi.ir             *
// * Email: support@paymentcms.ir                                          *
// * phone: 09361090413                                                    *
// *                                                                       *
// *                                                                       *
// *************************************************************************


use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class contracts_vote extends model implements modelInterFace {

	private $primaryKey = ['fillOutId'];
	private $primaryKeyShouldNotInsertOrUpdate = 'fillOutId';
	private $fillOutId;
	private $contractId ;
	private $voteId ;
	private $creatDate ;
	private $userId ;
	private $fillOutDate ;

	public function setFromArray($result) {
		$this->fillOutId = $result['fillOutId'] ;
		$this->contractId = $result['contractId'] ;
		$this->voteId = $result['voteId'] ;
		$this->creatDate = $result['creatDate'] ;
		$this->userId = $result['userId'] ;
		$this->fillOutDate = $result['fillOutDate'] ;
	}

	public function returnAsArray( ) {
		$array['fillOutId'] = $this->fillOutId ;
		$array['contractId'] = $this->contractId ;
		$array['voteId'] = $this->voteId ;
		$array['creatDate'] = $this->creatDate ;
		$array['userId'] = $this->userId ;
		$array['fillOutDate'] = $this->fillOutDate ;
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

	/**
	 * @return mixed
	 */
	public function getFillOutId() {
		return $this->fillOutId;
	}

	/**
	 * @param mixed $fillOutId
	 */
	public function setFillOutId($fillOutId) {
		$this->fillOutId = $fillOutId;
	}

	/**
	 * @return mixed
	 */
	public function getContractId() {
		return $this->contractId;
	}

	/**
	 * @param mixed $contractId
	 */
	public function setContractId($contractId) {
		$this->contractId = $contractId;
	}

	/**
	 * @return mixed
	 */
	public function getVoteId() {
		return $this->voteId;
	}

	/**
	 * @param mixed $voteId
	 */
	public function setVoteId($voteId) {
		$this->voteId = $voteId;
	}

	/**
	 * @return mixed
	 */
	public function getCreatDate() {
		return $this->creatDate;
	}

	/**
	 * @param mixed $creatDate
	 */
	public function setCreatDate($creatDate) {
		$this->creatDate = $creatDate;
	}

	/**
	 * @return mixed
	 */
	public function getFillOutDate() {
		return $this->fillOutDate;
	}

	/**
	 * @param mixed $fillOutDate
	 */
	public function setFillOutDate($fillOutDate) {
		$this->fillOutDate = $fillOutDate;
	}

	/**
	 * @return mixed
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}


}
