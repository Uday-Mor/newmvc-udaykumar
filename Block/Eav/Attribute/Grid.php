<?php
/**
 * 
 */
class Block_Eav_Attribute_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('eav/attribute/grid.phtml');
	}

	public function prepareData()
	{
		$query = "SELECT COUNT(`attribute_id`) FROM `eav_attribute`";
		$records = Ccc::getModel('Core_Adapter')->fetchOne($query);
		$pager = $this->getPager($records,$this->getData('pg'));
		$query = "SELECT * FROM `eav_attribute` LIMIT {$pager->recordPerPage} OFFSET {$pager->startLimit};";
		$attributes = Ccc::getModel('Eav_Attribute')->fetchAll($query);
		return $attributes;
	}
}