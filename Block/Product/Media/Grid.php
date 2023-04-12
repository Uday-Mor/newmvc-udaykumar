<?php
/**
 * 
 */
class Block_Product_Media_Grid extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('product/media/grid.phtml');
	}

	public function getProduct()
	{
		$productId = Ccc::getModel('Core_Request')->getParams('product_id');
		// $query = 'SELECT * FROM `product` WHERE `product_id` = "'.$productId.'"';
		$product = Ccc::getModel('Product')->load($productId);
		return $product;
	}
}