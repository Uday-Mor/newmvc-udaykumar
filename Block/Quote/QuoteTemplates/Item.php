<?php
/**
 * 
 */
class Block_Quote_QuoteTemplates_Item extends Block_Core_Grid
{

	protected $quote = null;

	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('quote/quotetemplates/item.phtml');
	}

	public function getQuote()
	{
		return $this->quote;
	}

	public function setQuote($quote)
	{
		$this->quote = $quote;
		return $this;
	}
}