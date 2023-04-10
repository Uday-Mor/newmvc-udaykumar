<?php
/**
 * 
 */
class Block_Product_Grid extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('product/grid.phtml');
	}

	public function prepareData()
	{
		$query = 'SELECT * FROM `product`';
		$products = Ccc::getModel('Product')->fetchAll($query);
		return $products;
	}
}