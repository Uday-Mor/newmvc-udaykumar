<?php
/**
 * 
 */
class Block_Salesman_Address extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/address.phtml');
	}

	public function prepareData()
	{
		return $this;
	}
}