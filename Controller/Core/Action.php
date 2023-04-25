<?php 

/**
 * 
 */
class Controller_Core_Action
{
   protected $request = Null;
   protected $adapter = Null;
   protected $url = null;
   protected $message = null;
   protected $view = null;
   protected $layout = null;
   protected $session = null;
   protected $response = null;

   protected function _setTitle($title)
   {
      $this->getLayout()->getChild('head')->setTitle($title);
      return $this;
   }

	protected function redirect($action=null,$controller=null,$params=null,$resetParam=false)
   {
      header('Location:'.$this->getModelUrl()->getUrl($action,$controller,$params,$resetParam));
      exit();
   }
   
   public function errorAction($error)
   {
       throw new Exception($error, 1);
   }

   protected function setRequest(Model_Core_Request $request)
   {
      $this->request = $request;
      return $this;
   }

   public function getRequest()
   {
      if ($this->request) {
         return $this->request;
      }
      $request = new Model_Core_Request();
      $this->setRequest($request);
      return $request;
   }

   public function setResponse(Model_Core_Response $response)
   {
      $this->response = $response;
      return $this;
   }

   public function getResponse()
   {
      if ($this->response !== null) {
         return $this->response;
      }
      $response = new Model_Core_Response();
      $response->setController($this);
      $this->setResponse($response);
      return $response;
   }

   public function setAdapter(Model_Core_Adapter $adapter)
   {
      $this->adapter = $adapter;
      return $this;
   }

   public function getAdapter()
   {
      if ($this->adapter !== null) {
         return $this->adapter;
      }
      $adapter = new Model_Core_Adapter();
      $this->setAdapter($adapter);
      return $adapter;
   }

   public function setModelUrl($url)
   {
      $this->url = $url;
   }

   public function getModelUrl()
   {
      if ($this->url) {
         return $this->url;
      }
      $url = new Model_Core_Url();
      $this->setModelUrl($url);
      return $url;
   }

   public function setMessage(Model_Core_Message $message)
   {
      $this->message = $message;
      return $this;
   }

   public function getMessage()
   {
      if ($this->message) {
         return $this->message;
      }
      $message = new Model_Core_Message();
      $this->setMessage($message);
      return $message;
   }

   public function setView(Model_Core_View $view)
   {
      $this->view = $view;
   }

   public function getView()
   {
      if ($this->view) {
         return $this->view;
      }
      $view = new Model_Core_View();
      $this->setView($view);
      return $view;
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

   public function setSession(Model_Core_Session $session)
   {
      $this->session = $session;
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

   public function renderLayout()
   {
      $this->getResponse()->setBody($this->getLayout()->toHtml());
   }
}
?>