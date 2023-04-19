<?php
/**
 * 
 */
class Block_Product_Edit extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setData(['product'=>Ccc::getModel('Product')])->setTemplate('product/edit.phtml');
	}

	public function prepareData()
	{
		return $this;
	}

	public function getAttributes()
	{
		$query = "SELECT * FROM `eav_attribute` WHERE `entity_type_id` = '".Model_Product_Resource::ENTITY_TYPE_ID."' AND `status` = '".Model_Product_Resource::STATUS_ACTIVE."'";
		$attributes = Ccc::getModel('Eav_Attribute')->fetchAll($query);
		return $attributes;
	}
}