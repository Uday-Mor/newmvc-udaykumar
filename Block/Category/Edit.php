<?php
/**
 * 
 */
class Block_Category_Edit extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setData(['category'=>Ccc::getModel('Category')])->setTemplate('category/edit.phtml');
	}

	public function prepareData()
	{
		return $this;
	}
}