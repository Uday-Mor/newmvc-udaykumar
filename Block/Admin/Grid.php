<?php
/**
 * 
 */
class Block_Admin_Grid extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('admin/grid.phtml');
	}

	public function prepareData()
	{
		$query = 'SELECT * FROM `admin`';
		$admins = Ccc::getModel('Admin')->fetchAll($query);
		return $admins;
	}
}