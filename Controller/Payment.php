<?php
/**
 * 
 */
class Controller_Payment extends Controller_Core_Action
{
	public function indexAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('index',$layout->creatBlock('Core_Layout')->setTemplate('payment/index.phtml'));
		echo $layout->toHtml();
	}

	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Payment_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
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
			$add = $layout->creatBlock('Payment_Edit');
			$response = $add->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
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
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Payment_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);			
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
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Payment_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
}