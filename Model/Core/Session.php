<?php

/**
 * 
 */
class Model_Core_Session
{
	public function getId()
	{
		return session_id();
	}

	public function start()
	{
		if (session_status() != 2) {
			session_start();
		}
		return $this;
	}

	public function destroy()
	{
		$this->start();
		session_destroy();
		return $this;
	}

	public function set($key,$value)
	{
		$this->start();
		$_SESSION[$key] = $value;
		return $this;
	}

	public function unset($key)
	{
		if ($this->has($key)) {
			unset($_SESSION[$key]);
		}
		return $this;
	}

	public function get($key = null)
	{
		if (!$this->has($key)) {
			return $_SESSION;
		}
		return $_SESSION[$key];
	}

	public function has($key)
	{
		$this->start();
		if (!array_key_exists($key,$_SESSION)) {
			return false;
		}
		return true;
	}
}
?>