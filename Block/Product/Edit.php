<?php
/**
 * 
 */
class Block_Product_Edit extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setData(['product'=>Ccc::getModel('Product')])->setTemplate('product/edit.phtml');
	}

	public function prepareData()
	{
		return $this;
	}
}