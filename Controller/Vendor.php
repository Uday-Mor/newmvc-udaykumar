<?php
/**
 * 
 */
class Controller_Vendor extends Controller_Core_Action
{
	public function indexAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('index',$layout->creatBlock('Core_Layout')->setTemplate('vendor/index.phtml'));
		echo $layout->toHtml();
	}

	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			if (!($pageNumber = $this->getRequest()->getParams('pg'))) {
				$pageNumber = 1;
			}
			$grid = $layout->creatBlock('Vendor_Grid')->setData(['pg'=>$pageNumber]);
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$add = $layout->creatBlock('Vendor_Edit');
			$response = $add->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
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
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Vendor_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
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
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Vendor_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage,Model_Core_Message::FAILURE);
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
			$response = $addressBlock->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
}