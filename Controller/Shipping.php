<?php
/**
 * 
 */
class Controller_Shipping extends Controller_Core_Action
{
	public function indexAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('index',$layout->creatBlock('Core_Layout')->setTemplate('shipping/index.phtml'));
		echo $layout->toHtml();
	}

	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			if (!($pageNumber = $this->getRequest()->getParams('pg'))) {
				$pageNumber = 1;
			}
			$grid = $layout->creatBlock('Shipping_Grid')->setData(['pg'=>$pageNumber]);
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			if (!($shipping = Ccc::getModel('Shipping'))) {
				$this->errorAction('Request denied!!!');
			}

			$layout = $this->getLayout();
			$add = $layout->creatBlock('Shipping_Edit');
			$response = $add->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}

	public function editAction()
	{
		try {
			if (!($shippingId = $this->getRequest()->getParams('shipping_id'))) {
				$this->errorAction('Invalid request!!!');
			}
			
			if (!($shipping = Ccc::getModel('Shipping')->load($shippingId))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Shipping_Edit');
			$edit->setData(['shipping'=>$shipping]);
			$response = $edit->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}

	public function saveAction()
	{
		try {
			if (!$this->getRequest()->isPost()) {
				$this->errorAction('Data is not posted!!');
			}

			if (!($postData = $this->getRequest()->getPost('shipping'))) {
				$this->errorAction('Data not found!!');
			}

			$shipping = Ccc::getModel('Shipping');
			if ($shippingId = (int) $this->getRequest()->getParams('shipping_id')) {
				if (!($shipping = $shipping->load($shippingId))) {
					$this->errorAction('Data not found to update!!!');
				}
			}

			if ($shipping->shipping_id) {
				$shipping->updated_at = date("Y-m-d h:i:sa");
			}else{
				$shipping->created_at = date("Y-m-d h:i:sa");
			}

			$shipping->setData($postData);
			if (!($shipping->save())) {
				$this->errorAction('Data not saved!!');
			}

			$this->getMessage()->addMessage('Data saved successfully!!!');
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Shipping_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);			
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function deleteAction()
	{
		try {
			if (!($shippingId = $this->getRequest()->getParams('shipping_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!$shipping = Ccc::getModel('Shipping')->load($shippingId)) {
				$this->errorAction('Data not found!!!');
			}

			if (!$shipping->delete()) {
				$this->errorAction('Failed to delete data!!!');
			}

			$this->getMessage()->addMessage('Data deleted successfully!!!');
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Shipping_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
}