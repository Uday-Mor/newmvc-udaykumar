<?php
/**
 * 
 */
class Model_Payment extends Model_Core_Table
{
	public $resourceClass = 'Payment_Resource';
	public $collectionClass = 'Payment_Collection';

	public function getStatusText()
	{
		$statues = $this->getResource()->getStatusOptions();
		if (array_key_exists($this->status,$statues)) {
			return $statues[$this->status];
		}
		return $statues[Model_Payment_Resource::STATUS_DEFAULT];
	}

	public function getStatus()
	{
		if ($this->status) {
			return $this->status;
		}
		return Model_Payment_Resource::STATUS_DEFAULT;
	}
}