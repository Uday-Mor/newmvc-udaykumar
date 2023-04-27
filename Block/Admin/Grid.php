<?php
/**
 * 
 */
class Block_Admin_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('admin/grid.phtml');
	}

	public function prepareData()
	{
		$query = "SELECT COUNT(`admin_id`) FROM `admin`";
		$records = Ccc::getModel('Core_Adapter')->fetchOne($query);
		$pager = $this->getPager($records,$this->getData('pg'));
		$query = "SELECT * FROM `admin` LIMIT {$pager->recordPerPage} OFFSET {$pager->startLimit};";
		$admins = Ccc::getModel('Admin')->fetchAll($query);
		return $admins;
	}
}