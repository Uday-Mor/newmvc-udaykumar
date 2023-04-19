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

	public function getChildHtml($key)
	{
		if ($child = $this->getChild()) {
			return $child->toHtml();
		}
		return null;
	}

	public function toHtml()
	{
		ob_start();
		$this->render();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
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
		if ($this->layout) {
			return $this->layout;
		}
		$layout = new Block_Core_Layout();
		$this->setLayout($layout);	
		return $layout;
	}
}