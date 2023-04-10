<?php 

/**
 * 
 */
class Controller_Customer extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('grid',$layout->creatBlock('Customer_Grid'));
			$layout->render();
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
			$layout->getChild('content')->addChild('grid',$layout->creatBlock('Customer_Edit'));
			$layout->render();
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

			if (!($customer = Ccc::getModel('Customer')->load($customerId)) || !($address = Ccc::getModel('Customer_Address')->load($customerId,'customer_address_id'))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Customer_Edit');
			$edit->setData(['customer'=>$customer,'address'=>$address]);
			$layout->getChild('content')->addChild('grid',$edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);	
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
			$address = Ccc::getModel('Customer_Address');
			if ($customerId = $this->getRequest()->getParams('customer_id')) {
				if (!($customer = $customer->load($customerId)) || !($address = $address->load($customerId,'customer_address_id'))) {
					$this->errorAction('Failed to fetch data!!!');
				}
			}

			if ($customer->customer_id) {
				$customer->updated_at = date("Y-m-d h:i:sa");
			}else{
				$customer->created_at = date("Y-m-d h:i:sa");
			}

			$customer->setData($customerData);
			if (!($insertId = $customer->save())) {
				$this->errorAction('Failed to save Data!!!');
			}

			if (!$address->address_id) {
				$address->customer_address_id = $insertId;
			}

			$address->setData($addressData);
			if (!$address->save()) {
				$this->errorAction('Failed to save Data!!!');
			}

			$this->getMessage()->addMessage('Data saved successfully!!!');
			$this->redirect('grid',null,[],true);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}
	
	public function deleteAction()
	{
		try {
			if (!($customerId = $this->getRequest()->getParams('customer_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			
			if (($customer = Ccc::getModel('Customer')->load($customerId)) && ($address = Ccc::getModel('Customer_Address')->load($customerId,'customer_address_id'))) {
				if (!$customer->delete() || $address->delete()) {
					$this->errorAction('Failed to delete data!!!');
				}
			}

			$this->getMessage()->addMessage('Data deleted successfully!!!');
			$this->redirect('grid',null,[],true);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage,Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
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
			$layout->getChild('content')->addChild('address',$addressBlock);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}
}
?>