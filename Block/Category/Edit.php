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

	public function getAttributes()
	{
		$query = 'SELECT * FROM `eav_attribute` WHERE `entity_type_id` = "'.Model_Category_Resource::ENTITY_TYPE_ID.'" AND `status` = "'.Model_Category_Resource::STATUS_ACTIVE.'"';
		$attributes = Ccc::getModel('Eav_Attribute')->fetchAll($query);
		return $attributes;
	}
}