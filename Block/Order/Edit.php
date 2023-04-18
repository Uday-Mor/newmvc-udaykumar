<?php
/**
 * 
 */
class Block_Order_Edit extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setData(['shipping'=>Ccc::getModel('Shipping')])->setTemplate('shipping/edit.phtml');
	}

	public function prepareData()
	{
		return $this;
	}
}