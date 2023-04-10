<?php
/**
 * 
 */
class Block_Html_Footer extends Block_Core_Templates
{	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('html/footer.phtml');
	}
}