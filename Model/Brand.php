<?php
/**
 * 
 */
class Model_Brand extends Model_Core_Table
{
	public $resourceClass = 'Brand_Resource';
    public $collectionClass = 'Brand_Collection';

    public function getStatusText()
    {
        $statues = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status,$statues)) {
            return $statues[$this->status];
        }
        return $statues[Model_Brand_Resource::STATUS_DEFAULT];
    }

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }
        return Model_Brand_Resource::STATUS_DEFAULT;
    }

    public function getAttributeValue($attribute)
    {
        $query = "SELECT `value` FROM `brand_{$attribute->backend_type}` WHERE `attribute_id` = '{$attribute->getId()}' AND `brand_id` = '{$this->getId()}'";
        return $this->getResource()->getAdapter()->fetchOne($query);
    }

    public function getOptions($attribute)
    {
        $query = "SELECT * FROM `eav_attribute_option` WHERE `attribute_id` = '{$attribute->getId()}'";
        return Ccc::getModel('Eav_Attribute_Option')->fetchAll($query)->getData();
    }
}