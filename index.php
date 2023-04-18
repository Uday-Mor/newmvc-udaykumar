<?php 

define('DS',DIRECTORY_SEPARATOR);
error_reporting(E_ALL);

spl_autoload_register(function ($className) {	
	$className = str_replace('_','/',$className).'.php'; 
    require_once $className;
});

$session = new Model_Core_Session();
$session->start();

if (!(Ccc::getModel('Core_Request')->getParams('c')) || !(Ccc::getModel('Core_Request')->getParams('a'))) {
	header('Location:http://localhost/newmvc-udaykumar/index.php?c=product&a=grid');
    exit();
}
/**
 * 
 */
class Ccc
{
	public static function init()
	{
		$front = new Controller_Core_Front();
		$front->init();
	}

	public static function getModel($className)
	{
		$className = 'Model_'.$className;
		return new $className();	
	}

	public static function log($data,$fileName = 'system.log',$newFile = false)
	{
		self::getSingleTon('Core_Log')->log($data,$fileName,$newFile);
	}

	public static function getSingleTon($className)
	{
		$className = 'Model_'.$className;
		if (array_key_exists($className,$GLOBALS)) {
			return $GLOBALS[$className];
		}
		$GLOBALS[$className] = new $className();
		return $GLOBALS[$className];
	}

	public static function register($key,$value)
	{
		$GLOBALS[$key] = $value;
	}

	public static function getRegistry($key)
	{
		if (array_key_exists($key,$GLOBALS)) {
			return $GLOBALS[$key];
		}
		return false;
	}

	public static function getBaseDir($subDir = null)
	{
		$dir = getcwd();
		if ($subDir) {
			$dir = $dir.$subDir;
		}
		return $dir;
	}
}
Ccc::init();
?>