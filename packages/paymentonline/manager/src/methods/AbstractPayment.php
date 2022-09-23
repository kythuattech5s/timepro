<?php
namespace paymentonline\manager\methods;
use paymentonline\manager\models\Transaction;
abstract class AbstractPayment{
	protected $currentUnit;
	protected $amount;
	protected $transaction;
	protected $urlReturn;
	abstract public function doTransfer();

	function __construct(Transaction $transaction){
		$this->transaction = $transaction;
		$this->amount = $this->transaction->amount;
	}

	public function setUrlReturn($urlReturn){
		$this->urlReturn = $urlReturn;
	}

	public function setAmount($amount){
		$this->amount = $amount;
	}

	public function getAmount(){
		return $this->amount;
	}

	public function setCurrentUnit($currentUnit)
	{
		$this->currentUnit = $currentUnit;
	}

	public function getCurrentUnit(){
		return $this->currentUnit;
	}
}