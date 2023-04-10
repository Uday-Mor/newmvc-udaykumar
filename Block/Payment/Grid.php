<?php
/**
 * 
 */
class Block_Payment_Grid extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('payment/grid.phtml');
	}

	public function prepareData()
	{
		$query = 'SELECT * FROM `payment`';
		$payments = Ccc::getModel('Payment')->fetchAll($query);
		return $payments;
	}
}