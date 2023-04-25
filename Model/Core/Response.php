<?php
/**
 * 
 */
class Model_Core_Response
{
	protected $_jsonData = [
		'status' => 'success',
		'message' => 'success',
		'messageBlockHtml' => null
	];
	protected $controller = null;

	public function setJsonData(array $data)
	{
		$this->_jsonData = array_merge($this->_jsonData,$data);
		return $this;
	}

	public function getJsonData()
	{
		return $this->_jsonData;
	}

	public function setMessageResponse()
	{
		$this->setJsonData(['messageBlockHtml'=>$this->getController()->getLayout()->creatBlock('Html_Message')->toHtml()]);
	}

	public function setController($controller)
	{
		$this->controller = $controller;
	}

	private function getController()
	{
		return $this->controller;
	}

	public function setBody($content)
	{
		echo $content;
	}

	public function jsonResponse($data)
	{
		$this->setJsonData($data);
		$this->setMessageResponse();
		echo json_encode($this->getJsonData());
	}
}