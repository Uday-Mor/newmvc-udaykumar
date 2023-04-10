<?php 
/**
 * 
 */
class Model_Salesman extends Model_Core_Table
{
	public $resourceClass = 'Salesman_Resource';
    public $collectionClass = 'Salesman_Collection';

    public function getStatusText()
    {
        $statues = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status,$statues)) {
            return $statues[$this->status];
        }
        return $statues[Model_Salesman_Resource::STATUS_DEFAULT];
    }

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }
        return Model_Salesman_Resource::STATUS_DEFAULT;
    }
}
?>