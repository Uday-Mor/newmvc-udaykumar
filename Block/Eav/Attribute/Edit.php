<?php
/**
 * 
 */
class Block_Eav_Attribute_Edit extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setData(['attribute'=>Ccc::getModel('Eav_Attribute')])->setTemplate('eav/attribute/edit.phtml');
	}

	public function prepareData()
	{
		return $this;
	}

	public function getOptions()
	{
		$attributeId = Ccc::getModel('Core_Request')->getParams('attribute_id');
		$query = 'SELECT * FROM `eav_attribute_option` WHERE `attribute_id` = "'.$attributeId.'"';
		$options = Ccc::getModel('Eav_Attribute_Option')->fetchAll($query);
		return $options;
	}

	public function getEntities()
	{
		$query = 'SELECT * FROM `entity_type`';
		$entities = Ccc::getModel('Core_Adapter')->fetchAll($query);
		return $entities;
	}
}