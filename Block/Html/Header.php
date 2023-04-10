<?php
/**
 * 
 */
class Block_Html_Header extends Block_Core_Templates
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('html/header.phtml');
	}
}