<?php
/**
 * 
 */
class Model_Vendor extends Model_Core_Table
{
	public $resourceClass = 'Vendor_Resource';
    public $collectionClass = 'Vendor_Collection';

    public function getStatusText()
    {
        $statues = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status,$statues)) {
            return $statues[$this->status];
        }
        return $statues[Model_Vendor_Resource::STATUS_DEFAULT];
    }

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }
        return Model_Vendor_Resource::STATUS_DEFAULT;
    }
}