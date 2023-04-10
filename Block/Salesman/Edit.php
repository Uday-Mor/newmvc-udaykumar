<?php
/**
 * 
 */
class Block_Salesman_Edit extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setData(['salesman'=>Ccc::getModel('Salesman'),'address'=>Ccc::getModel('Salesman_Address')])->setTemplate('salesman/edit.phtml');
	}

	public function prepareData()
	{
		return $this;
	}
}