<?php
/**
 * 
 */
class Block_Item_Edit extends Block_Core_Templates
{
	function __construct()
	{
		$this->setData(['item'=>Ccc::getModel('Item')])->setTemplate('item/edit.phtml');
	}

	public function prepareData()
	{
		return $this;	
	}

	public function getAttributes()
	{
		$query = "SELECT * FROM `eav_attribute` WHERE `entity_type_id` = '".Model_Item_Resource::ENTITY_TYPE_ID."' AND `status` = '".Model_Item_Resource::STATUS_ACTIVE."'";
		$attributes = Ccc::getModel('Eav_Attribute')->fetchAll($query);
		return $attributes->getData();
	}
}