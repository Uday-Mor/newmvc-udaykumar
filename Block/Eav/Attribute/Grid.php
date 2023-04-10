<?php
/**
 * 
 */
class Block_Eav_Attribute_Grid extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('eav/attribute/grid.phtml');
	}

	public function prepareData()
	{
		$query = 'SELECT * FROM `eav_attribute`';
		$attributes = Ccc::getModel('Eav_Attribute')->fetchAll($query);
		// $this->setData(['eav_attributes'=>$attributes]);
		return $attributes;
	}
}