<?php
/**
 * 
 */
class Model_Quote extends Model_Core_Table
{
	public $resourceClass = 'Quote_Resource';
    public $collectionClass = 'Quote_Collection';

    public function getStatusText()
    {
        $statues = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status,$statues)) {
            return $statues[$this->status];
        }
        return $statues[Model_Item_Resource::STATUS_DEFAULT];
    }

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }
        return Model_Item_Resource::STATUS_DEFAULT;
    }

    public function getQuote()
    {
        $quote = Ccc::getModel('Quote');
        if (array_key_exists('customer_id',Ccc::getModel('Core_Session')->get())) {
            $quote->load(Ccc::getModel('Core_Session')->get('customer_id'),'customer_id');
        }
        return $quote;
    }

    public function getCustomer()
    {
        if ($this->customer_id) {
            $customer = Ccc::getModel('Customer')->load($this->customer_id);
            return $customer;
        }
        return null;
    }

    public function getPayments()
    {
        $query = "SELECT * FROM `payment`";
        $payments = Ccc::getModel('Payment')->fetchAll($query);
        return $payments;
    }

    public function getProducts()
    {
        $query = "SELECT * FROM `product`";
        $products = Ccc::getModel('Product')->fetchAll($query);
        return $products;
    }

    public function getShippings()
    {
        $query = "SELECT * FROM `shipping`";
        $shippings = Ccc::getModel('Shipping')->fetchAll($query);
        return $shippings;
    }
    public function getItems()
    {
        $query = "SELECT * FROM `quote_item` WHERE `quote_id` = '{$this->getId()}'";
        $items = Ccc::getModel('Quote_Item')->fetchAll($query);
        return $items;
    }

    public function getQuoteBillingAddress()
    {
        $billingAddress = Ccc::getModel('Quote_Address')->load($this->billing_address_id);    
        if (!$billingAddress) {
            $billingAddress = $this->getCustomer()->getBillingAddress();    
            if (!$billingAddress) {
                $billingAddress = Ccc::getModel('Quote_Address');
            }
        }
        return $billingAddress;
    }

    public function getQuoteShippingAddress()
    {
        $shippingAddress = Ccc::getModel('Quote_Address')->load($this->shipping_address_id);    
        if (!$shippingAddress) {
            $shippingAddress = $this->getCustomer()->getShippingAddress();    
            if (!$shippingAddress) {
                $shippingAddress = Ccc::getModel('Quote_Address');
            }
        }

        return $shippingAddress;
    }

    public function shippingValue()
    {
        if ($this->shipping_id) {
            $shipping = Ccc::getModel('Shipping')->load($this->shipping_id);
            if ($shipping) {
                return $shipping->amount;
            }
        }
        return null;
    }
}