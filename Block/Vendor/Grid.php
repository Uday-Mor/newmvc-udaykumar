<?php
/**
 * 
 */
class Block_Vendor_Grid extends Block_Core_Templates
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('vendor/grid.phtml');
	}

	public function prepareData()
	{
		$query = 'SELECT * FROM `vendor`';
		$vendors = Ccc::getModel('Vendor')->fetchAll($query);
		return $vendors;
	}
}