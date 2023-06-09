<?php 
/**
 * 
 */
class Model_Customer extends Model_Core_Table
{
	public $resourceClass = 'Customer_Resource';
    public $collectionClass = 'Customer_Collection';

    public function getStatusText()
    {
        $statues = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status,$statues)) {
            return $statues[$this->status];
        }
        return $statues[Model_Customer_Resource::STATUS_DEFAULT];
    }

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }
        return Model_Customer_Resource::STATUS_DEFAULT;
    }

    public function getBillingAddress()
    {
        if ($this->billing_address_id) {
            $shippingAddress = Ccc::getModel('Customer_Address')->load($this->billing_address_id);
            return $shippingAddress;
        }
        return false;
    }

    public function getShippingAddress()
    {
        if ($this->shipping_address_id) {
            $shippingAddress = Ccc::getModel('Customer_Address')->load($this->shipping_address_id);
            return $shippingAddress;
        }
        return false;
    }
}
?>