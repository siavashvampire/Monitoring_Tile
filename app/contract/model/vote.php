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

class vote extends model implements modelInterFace {

	private $primaryKey = ['voteId'];
	private $primaryKeyShouldNotInsertOrUpdate = 'voteId';
	private $voteId ;
	private $voteName ;
	private $voteReceiver ;
	private $checkByUnit ;
	private $ShowToReceiver ;
	private $contractGroup ;

	public function setFromArray($result) {
		$this->voteId = $result['voteId'] ;
		$this->voteName = $result['voteName'] ;
		$this->voteReceiver = $result['voteReceiver'] ;
		$this->checkByUnit = $result['checkByUnit'] ;
		$this->ShowToReceiver = $result['ShowToReceiver'] ;
		$this->contractGroup = $result['contractGroup'] ;
	}

	public function returnAsArray( ) {
		$array['voteId'] = $this->voteId ;
		$array['voteName'] = $this->voteName ;
		$array['voteReceiver'] = $this->voteReceiver ;
		$array['checkByUnit'] = $this->checkByUnit ;
		$array['ShowToReceiver'] = $this->ShowToReceiver ;
		$array['contractGroup'] = $this->contractGroup ;
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
	public function getVoteName() {
		return $this->voteName;
	}

	/**
	 * @param mixed $voteName
	 */
	public function setVoteName($voteName) {
		$this->voteName = $voteName;
	}

	/**
	 * @return mixed
	 */
	public function getVoteReceiver() {
		return $this->voteReceiver;
	}

	/**
	 * @param mixed $voteReceiver
	 */
	public function setVoteReceiver($voteReceiver) {
		$this->voteReceiver = $voteReceiver;
	}

	/**
	 * @return mixed
	 */
	public function getCheckByUnit() {
		return $this->checkByUnit;
	}

	/**
	 * @param mixed $checkByUnit
	 */
	public function setCheckByUnit($checkByUnit) {
		$this->checkByUnit = $checkByUnit;
	}

	/**
	 * @return mixed
	 */
	public function getShowToReceiver() {
		return $this->ShowToReceiver;
	}

	/**
	 * @param mixed $ShowToReceiver
	 */
	public function setShowToReceiver($ShowToReceiver) {
		$this->ShowToReceiver = $ShowToReceiver;
	}

	/**
	 * @return mixed
	 */
	public function getContractGroup() {
		return $this->contractGroup;
	}

	/**
	 * @param mixed $contractGroup
	 */
	public function setContractGroup($contractGroup) {
		$this->contractGroup = $contractGroup;
	}


}
