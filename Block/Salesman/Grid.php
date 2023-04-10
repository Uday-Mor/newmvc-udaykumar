<?php
/**
 * 
 */
class Block_Salesman_Grid extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/grid.phtml');
	}

	public function prepareData()
	{
		$query = 'SELECT * FROM `salesman`';
		$salesmen = Ccc::getModel('Salesman')->fetchAll($query);
		return $salesmen;
	}
}