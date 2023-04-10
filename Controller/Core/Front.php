<?php 
/**
 * 
 */
class Controller_Core_Front
{
	public $request = Null;

   	//make function to set request variable
	protected function setRequest(Model_Core_Request $request)
	{
	  $this->request = $request;
	  return $this;
	}

	//make adapter request if null else return
	public function getRequest()
	{
		if ($this->request) {
		 	return $this->request;
		}
		
		$request = new Model_Core_Request();
		$this->setRequest($request);
		return $request;
	}

	public function init()
	{
		$request = $this->getRequest();
		$controllerName = 'Controller_'.ucwords($request->getControllerName(),'_');
		$fileName = str_replace('_','/',$controllerName).'.php'; 

		require_once $fileName;
		$controller = new $controllerName();
		$actionName = $request->getActionName().'Action';
		if (!method_exists($controller,$actionName)) {
			throw new Exception("Invalid request !!!", 1);
		}else{
		$controller->$actionName();
		}
	}
}

?>