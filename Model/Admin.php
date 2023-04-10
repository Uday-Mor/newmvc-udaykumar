<?php
/**
 * 
 */
class Model_Admin extends Model_Core_Table
{
	public $resourceClass = 'Admin_Resource';
    public $collectionClass = 'Admin_Collection';

    public function getStatusText()
    {
        $statues = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status,$statues)) {
            return $statues[$this->status];
        }
        return $statues[Model_Admin_Resource::STATUS_DEFAULT];
    }

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }
        return Model_Admin_Resource::STATUS_DEFAULT;
    }
}