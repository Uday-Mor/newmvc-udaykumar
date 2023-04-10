<?php
class Model_Core_Request
{
	public function isPost()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") 
		{
			return false;
		}
		return true;
	}

	public function getPost($key = NULL, $value = NULL)
	{
		if ($key == NULL) 
		{
			return $_POST;
		}
		if (array_key_exists($key,$_POST))
		{
			return $_POST[$key];
		}
		return $value;
	}

	public function getParams($key = NULL, $value = NULL)
	{
		if ($key == NULL) 
		{
			return $_GET;
		}
		if (array_key_exists($key, $_GET))
		{
			return $_GET[$key];
		}
		return $value;
	}

	public function getActionName()
	{
		return $this->getParams('a','grid');
	}

	public function getControllerName()
	{
		return $this->getParams('c','product');
	}	
}
?>