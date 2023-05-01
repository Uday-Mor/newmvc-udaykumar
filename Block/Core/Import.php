<?php
/**
 * 
 */
class Block_Core_Import extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('core/import.phtml');
	}
}