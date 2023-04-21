<?php
/**
 * 
 */
class Block_Quote_Quote extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('quote/quote.phtml');
		$this->setTitle('Manage Quote');
	}

	public function getCustomers()
	{
		$query = "SELECT * FROM `customer`";
		return Ccc::getModel('Customer')->fetchAll($query);
	}

	public function getQuote()
	{
		$quote = Ccc::getModel('Quote');
		if (array_key_exists('customer_id',Ccc::getModel('Core_Session')->get())) {
			$quote->load(Ccc::getModel('Core_Session')->get('customer_id'),'customer_id');
		}
		return $quote;
	}
}