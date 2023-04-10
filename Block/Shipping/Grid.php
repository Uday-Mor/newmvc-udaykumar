<?php
/**
 * 
 */
class Block_Shipping_Grid extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('shipping/grid.phtml');
	}

	public function prepareData()
	{
		$query = 'SELECT * FROM `shipping`';
		$shippings = Ccc::getModel('Shipping')->fetchAll($query);
		return $shippings;
	}
}