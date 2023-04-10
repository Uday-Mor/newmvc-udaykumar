<?php
/**
 * 
 */
class Block_Customer_Address extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('customer/address.phtml');
	}
}