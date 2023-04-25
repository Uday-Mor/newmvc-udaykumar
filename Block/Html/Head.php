<?php
/**
 * 
 */
class Block_Html_Head extends Block_Core_Templates
{
	protected $title = 'ECOM SITE';
	protected $javascripts = [];
	protected $stylesheetss = [];

	function __construct()
	{
		parent::__construct();
		$this->setTemplate('html/head.phtml');
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function addJs($src)
	{
		$this->javascripts[] = $src;
		return $this;
	}

	public function getJs()
	{
		return $this->javascripts;
	}
}