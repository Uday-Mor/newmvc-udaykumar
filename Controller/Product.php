<?php
/**
 * 
 */
class Controller_Product extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('grid',$layout->creatBlock('Product_Grid'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			if (!($product = Ccc::getModel('Product'))) {
				$this->errorAction('Request denied!!!');
			}

			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('grid',$layout->creatBlock('Product_Edit'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}

	public function editAction()
	{
		try {
			if (!($productId = $this->getRequest()->getParams('product_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!($product = Ccc::getModel('Product')->load($productId))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = new Block_Product_Edit();
			$edit->setData(['product'=>$product]);
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

			if (!($postData = $this->getRequest()->getPost('product'))) {
				$this->errorAction('Data is not found!!!');
			}

			$product = Ccc::getModel('Product');
			if ($productId = $this->getRequest()->getParams('product_id')) {
				if (!($product = $product->load($productId))) {
					$this->errorAction('Failed to fetch data!!!');
				}
			}
			
			if ($product->product_id) {
				$product->updated_at = date("Y-m-d h:i:sa");
			}else{
				$product->created_at = date("Y-m-d h:i:sa");
			}

			$product->setData($postData);
			if (!($product->save())) {
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
			if (!($productId = $this->getRequest()->getParams('product_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if ($product = Ccc::getModel('Product')->load($productId)) {
				if (!$product->delete()) {
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
}