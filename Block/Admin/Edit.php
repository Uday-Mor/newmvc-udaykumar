<?php
/**
 * 
 */
class Block_Admin_Edit extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setData(['admin'=>Ccc::getModel('Admin')])->setTemplate('admin/edit.phtml');
	}

	public function prepareData()
	{
		return $this;
	}
}