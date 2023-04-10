<?php
/**
 * 
 */
class Block_Vendor_Address extends Block_Core_Templates
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('vendor/address.phtml');
	}

	public function prepareData()
	{
		$vendorId = Ccc::getModel('Core_Request')->getParams('vendor_id');
		$address = Ccc::getModel('Vendor_Address')->load($vendorId,'vendor_address_id');
		return $address;
	}
}