<?php
/**
 * 
 */
class Block_Core_Pager extends Block_Core_Templates
{
	protected $pager = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('core/pager.phtml');
	}

	public function getPager()
	{
		return $this->pager;
	}

	public function setPager(Model_Core_Pager $pager)
	{
		$this->pager = $pager;
		return $this;
	}
}