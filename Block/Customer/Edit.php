<?php
/**
 * 
 */
class Block_Customer_Edit extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setData(['customer'=>Ccc::getModel('Customer'),'billing_address'=>Ccc::getModel('Customer_Address'),'shipping_address'=>Ccc::getModel('Customer_Address')])->setTemplate('customer/edit.phtml');
	}

	public function prepareData()
	{
		return $this;
	}
}