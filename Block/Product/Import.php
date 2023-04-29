<?php
/**
 * 
 */
class Block_Product_Import extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('product/import.phtml');
	}
}