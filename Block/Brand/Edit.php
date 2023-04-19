<?php
/**
 * 
 */
class Block_Brand_Edit extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setData(['brand'=>Ccc::getModel('Brand')])->setTemplate('brand/edit.phtml');
	}

	public function prepareData()
	{
		return $this;
	}

	public function getAttributes()
	{
		$query = "SELECT * FROM `eav_attribute` WHERE `entity_type_id` = '".Model_Brand_Resource::ENTITY_TYPE_ID."' AND `status` = '".Model_Brand_Resource::STATUS_ACTIVE."'";
		$attributes = Ccc::getModel('Eav_Attribute')->fetchAll($query);
		if (!$attributes) {
			return null;
		}
		return $attributes->getData();
	}
}