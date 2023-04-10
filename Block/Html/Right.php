<?php
/**
 * 
 */
class Block_Html_Right extends Block_Core_Templates
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('html/right.phtml');
	}
}