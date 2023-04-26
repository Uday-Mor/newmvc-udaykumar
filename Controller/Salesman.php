<?php 
/**
 * 
 */
class Controller_Salesman extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			if (!($pageNumber = $this->getRequest()->getParams('pg'))) {
				$pageNumber = 1;
			}
			$grid = $layout->creatBlock('Salesman_Grid')->setData(['pg'=>$pageNumber]);
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
	
	public function addAction()
	{
		try {
			if (!($salesman = Ccc::getModel('Salesman')) || !($address = Ccc::getModel('Salesman_Address'))) {
				$this->errorAction('Request denied!!!');
			}
			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('edit',$layout->creatBlock('Salesman_Edit'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}
	
	public function editAction()
	{
		try {
			if (!($salesmanId = $this->getRequest()->getParams('salesman_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!($salesman = Ccc::getModel('Salesman')->load($salesmanId))) {
				$this->errorAction('Data not found!!!');
			}

			if (!($address = Ccc::getModel('Salesman_Address')->load($salesmanId,'salesman_address_id'))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Salesman_Edit');
			$edit->setData(['salesman'=>$salesman,'address'=>$address]);
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

			if (!($salesmanData = $this->getRequest()->getPost('salesman'))) {
				$this->errorAction('Data is not found!!!');
			}

			if (!($addressData = $this->getRequest()->getPost('address'))) {
				$this->errorAction('Data is not found!!!');
			}

			$salesman = Ccc::getModel('Salesman');
			$address = Ccc::getModel('Salesman_Address');
			if ($salesmanId = $this->getRequest()->getParams('salesman_id')) {
				if (!($salesman = $salesman->load($salesmanId)) || !($address = $address->load($salesmanId,'salesman_address_id'))) {
					$this->errorAction('Failed to fetch data!!!');
				}
			}

			if ($salesman->salesman_id) {
				$salesman->updated_at = date("Y-m-d h:i:sa");
			}else{
				$salesman->created_at = date("Y-m-d h:i:sa");
			}

			$salesman->setData($salesmanData);
			if (!($insertId = $salesman->save())) {
				$this->errorAction('Failed to save Data!!!');
			}

			if (!$address->address_id) {
				$address->salesman_address_id = $insertId;
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
			if (!($salesmanId = $this->getRequest()->getParams('salesman_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (($salesman = Ccc::getModel('Salesman')->load($salesmanId)) && ($address = Ccc::getModel('Salesman_Address')->load($salesmanId,'salesman_address_id'))) {
				if (!$salesman->delete() || $address->delete()) {
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
			if (!($salesmanId = $this->getRequest()->getParams('salesman_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			$layout = $this->getLayout();
			$address = Ccc::getModel('Salesman_Address')->load($salesmanId,'salesman_address_id');
			$addressBlock = $layout->creatBlock('Salesman_Address')->setData(['address'=>$address]);
			$layout->getChild('content')->addChild('address',$addressBlock);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}
}
?>