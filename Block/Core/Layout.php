<?php
/**
 * 
 */
class Block_Core_Layout extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('core/layout/1column.phtml');
		$this->prepareChildren();
	}

	public function prepareChildren()
	{
		$head = $this->creatBlock('Html_Head');
		$this->addChild('head',$head);
		$header = $this->creatBlock('Html_Header');
		$this->addChild('header',$header);
		$message = $this->creatBlock('Html_Message');
		$this->addChild('message',$message);
		$left = $this->creatBlock('Html_Left');
		$this->addChild('left',$left);
		$content = $this->creatBlock('Html_Content');
		$this->addChild('content',$content);
		$right = $this->creatBlock('Html_Right');
		$this->addChild('right',$right);
		$footer = $this->creatBlock('Html_Footer');
		$this->addChild('footer',$footer);
	}

	public function creatBlock($blockName)
	{
		$blockName = 'Block_'.$blockName;
		$block = new $blockName();
		$block->setLayout($this);
		return $block;
	}


}