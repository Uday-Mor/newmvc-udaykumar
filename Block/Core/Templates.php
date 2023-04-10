<?php
/**
 * 
 */
class Block_Core_Templates extends Model_Core_View
{
	protected $children = [];
	protected $layout = null;

	public function __construct()
	{
		parent::__construct();
	}

	public function setChildren(array $children)
	{
		$this->children = $children;
		return $this;
	}

	public function getChildren()
	{
		return $this->children;
	}

	public function addChild($key,$children)
	{
		$this->children[$key] = $children;
		return $this;
	}

	public function getChild($key)
	{
		if (!array_key_exists($key,$this->children)) {
			return false;
		}
		return $this->children[$key];
	}

	public function removeChild($key)
	{
		unset($this->children[$key]);
		return $this;
	}

	public function setLayout(Block_Core_Layout $layout)
	{
		$this->layout = $layout;
	}

	public function getLayout()
	{
		return $this->layout;
	}
}