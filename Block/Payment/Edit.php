<?php
/**
 * 
 */
class Block_Payment_Edit extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setData(['payment'=>Ccc::getModel('Payment')])->setTemplate('payment/edit.phtml');
	}

	public function prepareData()
	{
		return $this;
	}
}