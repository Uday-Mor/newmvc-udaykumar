<?php
/**
 * 
 */
class Block_Customer_Grid extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('customer/grid.phtml');
	}

	public function prepareData()
	{
		$query = 'SELECT * FROM `customer`';
		$customeres = Ccc::getModel('Customer')->fetchAll($query);
		return $customeres;
	}
}