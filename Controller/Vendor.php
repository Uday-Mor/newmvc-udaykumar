<?php
/**
 * 
 */
class Controller_Vendor extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$content = $layout->getChild('content')->addChild('grid',$layout->creatBlock('Vendor_Grid'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$content = $layout->getChild('content')->addChild('edit',$layout->creatBlock('Vendor_Edit'));
			$layout->setTemplate('core/layout/2column.phtml')->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}

	public function editAction()
	{
		try {
			if (!($vendorId = $this->getRequest()->getParams('vendor_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!($vendor = Ccc::getModel('Vendor')->load($vendorId)) || !($address = Ccc::getModel('Vendor_Address')->load($vendorId,'vendor_address_id'))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Vendor_Edit');
			$edit->setData(['vendor'=>$vendor,'address'=>$address]);
			$content = $layout->getChild('content')->addChild('edit',$edit);
			$layout->setTemplate('core/layout/2column.phtml')->render();
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

			if (!($vendorData = $this->getRequest()->getPost('vendor'))) {
				$this->errorAction('Data is not found!!!');
			}

			if (!($addressData = $this->getRequest()->getPost('address'))) {
				$this->errorAction('Data is not found!!!');
			}

			$vendor = Ccc::getModel('Vendor');
			$address = Ccc::getModel('Vendor_Address');
			if ($vendorId = $this->getRequest()->getParams('vendor_id')) {
				if (!($vendor = $vendor->load($vendorId)) || !($address = $address->load($vendorId,'vendor_address_id'))) {
					$this->errorAction('Failed to fetch data!!!');
				}
			}

			if ($vendor->vendor_id) {
				$vendor->updated_at = date("Y-m-d h:i:sa");
			}else{
				$vendor->created_at = date("Y-m-d h:i:sa");
			}

			$vendor->setData($vendorData);
			if (!($insertId = $vendor->save())) {
				$this->errorAction('Failed to save Data!!!');
			}

			if (!$address->address_id) {
				$address->vendor_address_id = $insertId;
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
			if (!($vendorId = $this->getRequest()->getParams('vendor_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (($vendor = Ccc::getModel('Vendor')->load($vendorId)) && ($address = Ccc::getModel('Vendor_Address')->load($vendorId,'vendor_address_id'))) {
				if (!$vendor->delete() || $address->delete()) {
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
			if (!($vendorId = $this->getRequest()->getParams('vendor_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!($address = Ccc::getModel('Vendor_Address')->load($vendorId,'vendor_address_id'))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$addressBlock = $layout->creatBlock('Vendor_Address');
			$addressBlock->setData(['address'=>$address]);
			$layout->getChild('content')->addChild('address',$addressBlock);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}
}