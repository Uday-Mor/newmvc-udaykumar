<?php
/**
 * 
 */
class Model_Core_Url
{
	public function getCurrentUrl()
	{
		$url=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return $url;
	}

	public function getUrl($action=null,$controller=null,$params=null,$resetParam=false)
	{
		$request = new Model_Core_Request();	
		$queryStringArray = [];
		if (!$resetParam) {
			$queryStringArray = $request->getParams();
		}
		
		if($controller){
			$queryStringArray['c'] = $controller;
		}else{
			$queryStringArray['c'] = $request->getControllerName();
		}

		if($action){
			$queryStringArray['a'] = $action;
		}else{
			$queryStringArray['a'] = $request->getActionName();
		}

		if ($params) {
			$queryStringArray = array_merge($queryStringArray,$params);
		}

		$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].trim($_SERVER['REQUEST_URI'],$_SERVER['QUERY_STRING']).http_build_query($queryStringArray);
		return $url;
	}

}
//array object integer string
?>