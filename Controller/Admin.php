<?php
/**
 * 
 */
class Controller_Admin extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('grid',$layout->creatBlock('Admin_Grid'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid','product',[],true);
		}
	}

	public function addAction()
	{
		try {
			if (!($admin = Ccc::getModel('Admin'))) {
				$this->errorAction('Request denied!!!');
			}

			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('edit',$layout->creatBlock('Admin_Edit'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}

	public function editAction()
	{
		try {
			if (!($adminId = $this->getRequest()->getParams('admin_id'))) {
				$this->errorAction('Invalid request!!!');
			}
			
			if (!($admin = Ccc::getModel('Admin')->load($adminId))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Admin_Edit');
			$edit->setData(['admin'=>$admin]);
			$layout->getChild('content')->addChild('content',$edit);
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
				$this->errorAction('Data is not posted!!');
			}

			if (!($postData = $this->getRequest()->getPost('admin'))) {
				$this->errorAction('Data not found!!');
			}

			$admin = Ccc::getModel('Admin');
			if ($adminId = (int) $this->getRequest()->getParams('admin_id')) {
				if (!($admin = $admin->load($adminId))) {
					$this->errorAction('Data not found to update!!!');
				}
			}

			if ($admin->admin_id) {
				$admin->updated_at = date("Y-m-d h:i:sa");
			}else{
				$admin->created_at = date("Y-m-d h:i:sa");
			}

			$admin->setData($postData);
			if (!($admin->save())) {
				$this->errorAction('Data not saved!!');
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
			if (!($adminId = $this->getRequest()->getParams('admin_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!$admin = Ccc::getModel('Admin')->load($adminId)) {
				$this->errorAction('Data not found!!!');
			}

			if (!$admin->delete()) {
				$this->errorAction('Failed to delete data!!!');
			}

			$this->getMessage()->addMessage('Data deleted successfully!!!');
			$this->redirect('grid',null,[],true);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}
}