<?php
/**
 * 
 */
class Block_Html_Head extends Block_Core_Templates
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('html/head.phtml');
	}
}