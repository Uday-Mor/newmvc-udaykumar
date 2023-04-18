<?php 
/**
 * 
 */
class Model_Core_View
{
	protected $template = null;
	protected $data = [];

	public function __construct()
	{
		
	}

	public function __set($key,$value)
	{
		$this->data[$key] = $value;
	}

	public function __get($key)
	{
		if (!array_key_exists($key,$this->data)) {
			return null;
		}
		return $this->data[$key];
	}

	public function __unset($key)
	{
		unset($this->data[$key]);
	}

	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	public function getData($key)
	{
		if (!array_key_exists($key,$this->data)) {
			return false;
		}
		return $this->data[$key];
	}

	public function setTemplate($template)
	{
		$this->template = $template;
		return $this;
	}

	public function getTemplate()
	{
		return $this->template;
	}

	public function render()
	{
		require 'View'.DS.$this->getTemplate();
	}

	public function getUrl($action = null,$controller = null,$params=null,$resetParam = false)
	{
		return Ccc::getModel('Core_Url')->getUrl($action,$controller,$params,$resetParam);
	}
}
?>