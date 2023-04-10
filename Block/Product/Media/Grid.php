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

	public function prepareData()
	{
		$productId = Ccc::getModel('Core_Request')->getParams('product_id');
		$query = 'SELECT * FROM `product_media` WHERE `product_id` = "'.$productId.'"';
		$rowModel = Ccc::getModel('Product_Media');
		$images = $rowModel->fetchAll($query);
		return $images;
	}
}