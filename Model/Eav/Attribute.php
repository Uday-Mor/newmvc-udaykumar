<?php
/**
 * 
 */
class Model_Eav_Attribute extends Model_Core_Table
{
	public $resourceClass = 'Eav_Attribute_Resource';
	public $collectionClass = 'Eav_Attribute_Collection';

	public function getStatusText()
	{
		$statues = $this->getResource()->getStatusOptions();
		if (array_key_exists($this->status,$statues)) {
			return $statues[$this->status];
		}
		return $statues[Model_Eav_Attribute_Resource::STATUS_DEFAULT];
	}

	public function getStatus()
	{
		if ($this->status) {
			return $this->status;
		}
		return Model_Eav_Attribute_Resource::STATUS_DEFAULT;
	}

	public function getOptions()
	{
		$query = "SELECT * FROM `eav_attribute_option` WHERE `attribute_id` = '{$this->getId()}'";
		$options = Ccc::getModel('Eav_Attribute_Option')->fetchAll($query);
		return $options->getData();
	}
}