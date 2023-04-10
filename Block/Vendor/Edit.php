<?php
/**
 * 
 */
class Block_Vendor_Edit extends Block_Core_Templates
{
	function __construct()
	{
		$this->setData(['vendor'=>Ccc::getModel('Vendor'),'address'=>Ccc::getModel('Vendor_Address')])->setTemplate('vendor/edit.phtml');
	}

	public function prepareData()
	{
		return $this;	
	}
}