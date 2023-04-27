<?php 

/**
 * 
 */
class Controller_Customer extends Controller_Core_Action
{
	public function indexAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('index',$layout->creatBlock('Core_Layout')->setTemplate('customer/index.phtml'));
		echo $layout->toHtml();
	}

	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			if (!($pageNumber = $this->getRequest()->getParams('pg'))) {
				$pageNumber = 1;
			}
			$grid = $layout->creatBlock('Customer_Grid')->setData(['pg'=>$pageNumber]);
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getmessage(),'failure');
		}
	}
	
	public function addAction()
	{
		try {
			if (!($customer = Ccc::getModel('Customer')) || !($address = Ccc::getModel('Customer_Address'))) {
				$this->errorAction('Request denied!!!');
			}

			$layout = $this->getLayout();
			$add = $layout->creatBlock('Customer_Edit');
			$response = $add->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}
	
	public function editAction()
	{
		try {
			if (!($customerId = $this->getRequest()->getParams('customer_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!($customer = Ccc::getModel('Customer')->load($customerId))) {
				$this->errorAction('Data not found!!!');
			}

			if (!($billingAddress = $customer->getBillingaddress())) {
				$billingAddress = Ccc::getModel('Customer_Address');
			}

			if (!($shippingaddress = $customer->getShippingAddress())) {
				$shippingaddress = Ccc::getModel('Customer_Address');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Customer_Edit');
			$edit->setData(['customer'=>$customer,'billing_address'=>$billingAddress,'shipping_address'=>$shippingaddress]);
			$response = $edit->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function saveAction()
	{
		try {
			if (!$this->getRequest()->isPost()) {
				$this->errorAction('Data is not posted!!!');
			}

			if (!($customerData = $this->getRequest()->getPost('customer'))) {
				$this->errorAction('Data is not found!!!');
			}

			if (!($addressData = $this->getRequest()->getPost('address'))) {
				$this->errorAction('Data is not found!!!');
			}

			$customer = Ccc::getModel('Customer');
			if ($customerId = (int) $this->getRequest()->getParams('customer_id')) {
				if (!($customer = $customer->load($customerId))) {
					$this->errorAction('Failed to fetch data!!!');
				}
			}

			if (!($billingAddress = $customer->getBillingaddress())) {
				$billingAddress = Ccc::getModel('Customer_Address');
			}

			if (!($shippingAddress = $customer->getShippingAddress())) {
				$shippingAddress = Ccc::getModel('Customer_Address');
			}

			unset($customer->billing_address_id);
			unset($customer->shipping_address_id);
			if ($customer->getId()) {
				$customer->updated_at = date("Y-m-d h:i:s");
			}else{
				$customer->created_at = date("Y-m-d h:i:s");
			}

			$customer->setData($customerData);

			if (!($insertId = $customer->save())) {
				$this->errorAction('Failed to save Data!!!');
			}

			if (!$customer->getId()) {
				$customer->customer_id = $insertId;
			}

			$billingAddress->customer_address_id = $customer->getId();
			$shippingAddress->customer_address_id = $customer->getId();
			$billingAddress->setData($addressData['billing_address']);
			$shippingAddress->setData($addressData['shipping_address']);
			if (!($billingAddressId = $billingAddress->save()) || !($shippingAddressId = $shippingAddress->save())) {
				$this->errorAction('Failed to save Data!!!');
			}

			if (!$billingAddress->address_id) {
				$customer->billing_address_id = $billingAddressId;
			}

			if (!$shippingAddress->address_id) {
				$customer->shipping_address_id = $shippingAddressId;
			}

			if (!$customer->save()) {
				$this->errorAction('Failed to save Data!!!');
			}

			$this->getMessage()->addMessage('Data saved successfully!!!');
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Customer_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
	
	public function deleteAction()
	{
		try {
			if (!($customerId = $this->getRequest()->getParams('customer_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			
			if (($customer = Ccc::getModel('Customer')->load($customerId))) {
				if (!$customer->delete()) {
					$this->errorAction('Failed to delete data!!!');
				}
			}

			$this->getMessage()->addMessage('Data deleted successfully!!!');
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Customer_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage,Model_Core_Message::FAILURE);
		}
	}
	
	public function addressAction()
	{
		try {
			if (!($customerId = $this->getRequest()->getParams('customer_id'))) {
				$this->errorAction('Invalid request !!!');
			}

			if (!($address = Ccc::getModel('Customer_Address')->load($customerId,'customer_address_id'))) {
				$this->errorAction('Data not found !!!');
			}

			$layout = $this->getLayout();
			$addressBlock = $layout->creatBlock('Customer_Address');
			$addressBlock->setData(['address'=>$address]);
			$response = $addressBlock->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}
}
?>