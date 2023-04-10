<?php 
/**
 * 
 */
class Model_Core_Message
{
	protected $session = null;
	const SUCCESS = 'success';
	const FAILURE = 'failure';

	public function __construct()
	{
		$this->getSession();
	}

	public function setSession($session)
	{
		$this->session = $session;
		return $this;
	}

	public function getSession()
	{
		if ($this->session) {
			return $this->session;
		}
		$session = new Model_Core_Session();
		$this->setSession($session);
		return $session;
	}

	public function addMessage($message,$type = self::SUCCESS)
	{
		if ($this->getMessages()) {
			$messages = $this->getMessages();
		}
		$messages[$type] = $message;
		$this->getSession()->set('message',$messages);
		return $this;
	}

	public function getMessages()
	{
		if (!$this->getSession()->has('message')) {
			return [];
		}
		$messages = $this->getSession()->get('message');
		return $messages;
	}

	public function clearMessages()
	{
		$this->getSession()->set('message',[]);
		return $this;
	}
}
?>