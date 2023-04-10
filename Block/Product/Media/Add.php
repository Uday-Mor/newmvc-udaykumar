<?php
/**
 * 
 */
class Block_Product_Media_Add extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('product/media/add.phtml');
	}

	public function prepareData()
	{
		return $this;
	}
}