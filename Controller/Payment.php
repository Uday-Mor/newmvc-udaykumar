<?php
/**
 * 
 */
class Controller_Payment extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('grid',$layout->creatBlock('Payment_Grid'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			if (!($payment = Ccc::getModel('Payment'))) {
				$this->errorAction('Request denied!!!');
			}
			
			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('edit',$layout->creatBlock('Payment_Edit'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}

	public function editAction()
	{
		try {
			if (!($paymentId = $this->getRequest()->getParams('payment_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!($payment = Ccc::getModel('Payment')->load($paymentId))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Payment_Edit');
			$edit->setData(['payment'=>$payment]);
			$layout->getChild('content')->addChild('edit',$edit);
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

			if (!($postData = $this->getRequest()->getPost('payment'))) {
				$this->errorAction('Data not found!!!');
			}

			$payment = Ccc::getModel('Payment');
			if ($paymentId = $this->getRequest()->getParams('payment_id')) {
				if (!$payment->load($paymentId)) {
					$this->errorAction('Data not found!!!');
				}
			}

			if ($payment->payment_id) {
				$payment->updated_at = date("Y-m-d h:i:sa");
			}else{
				$payment->created_at = date("Y-m-d h:i:sa");
			}

			$payment->setData($postData);
			if (!$payment->save()) {
				$this->errorAction('Data not saved successfully!!!');
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
			if (!($paymentId = $this->getRequest()->getParams('payment_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if ($payment = Ccc::getModel('Payment')->load($paymentId)) {
				if (!$payment->delete()) {
					$this->errorAction('Failed to delete data!!!');
				}
			}

			$this->getMessage()->addMessage('Data deleted successfully!!!');
			$this->redirect('grid',null,[],true);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}
}