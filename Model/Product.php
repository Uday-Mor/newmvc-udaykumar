<?php
/**
 * 
 */
class Model_Product extends Model_Core_Table
{
	public $resourceClass = 'Product_Resource';
	public $collectionClass = 'Product_Collection';

	public function getStatusText()
	{
		$statues = $this->getResource()->getStatusOptions();
		if (array_key_exists($this->status,$statues)) {
			return $statues[$this->status];
		}
		return $statues[Model_Product_Resource::STATUS_DEFAULT];
	}

	public function getStatus()
	{
		if ($this->status) {
			return $this->status;
		}
		return Model_Product_Resource::STATUS_DEFAULT;
	}

	public function getImages()
    {
        $query = 'SELECT * FROM `product_media` WHERE `product_id` = "'.$this->product_id.'"';
        $images = Ccc::getModel('Product_Media')->fetchAll($query);
        return $images;
    }

    public function getBase()
    {
    	return $this->base;
    }

    public function getThumnail()
    {
    	return $this->thumnail;
    }

    public function getSmall()
    {
    	return $this->small;
    }

    public function getAttributeValue($attribute)
    {
        $query = "SELECT `value` FROM `product_{$attribute->backend_type}` WHERE `attribute_id` = '{$attribute->getId()}' AND `entity_id` = '{$this->getId()}'";
        return $this->getResource()->getAdapter()->fetchOne($query);
    }
}