<?php
/**
 * 
 */
class Controller_Item extends Controller_Core_Action
{
	public function gridAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('grid',$layout->creatBlock('Item_Grid'));
		$layout->render();
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('add',$layout->creatBlock('Item_Edit'));
			$layout->render();
		} catch (Exception $e) {
			
		}
	}

	public function editAction()
	{
		try {
			if (!($itemId = $this->getRequest()->getParams('item_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!($item = Ccc::getModel('Item')->load($itemId))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Item_Edit');
			$edit->setData(['item'=>$item]);
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

			if (!($postData = $this->getRequest()->getPost('item'))) {
				$this->errorAction('Data not found!!!');
			}


			$item = Ccc::getModel('Item');
			if ($itemId = $this->getRequest()->getParams('item_id')) {
				if (!$item->load($itemId)) {
					$this->errorAction('Data not found!!!');
				}
			}

			if ($item->item_id) {
				$item->updated_at = date("Y-m-d h:i:sa");
			}else{
				$item->created_at = date("Y-m-d h:i:sa");
			}

			$item->setData($postData);
			if (!($insertId = $item->save())) {
				$this->errorAction('Data not saved successfully!!!');
			}

			if (!$item->item_id) {
				$item->item_id = $insertId;
			}

			$attributePostData = $this->getRequest()->getPost('attribute');
			if ($attributePostData) {
				foreach ($attributePostData as $backendType => $attributes) {
					foreach ($attributes as $attributeId => $value) {
						if(is_array($value)){
							$value = implode(",", $value);
						}

						$model = Ccc::getModel("Core_Table");
						$model->getResource()->setTableName("item_{$backendType}")->setPrimaryKey('value_id');
						$query = "INSERT INTO `item_{$backendType}` (`item_id`,`attribute_id`,`value`) VALUES ('{$item->getId()}','{$attributeId}','{$value}') ON DUPLICATE KEY UPDATE `value` = '{$value}'";
						$model->getResource()->getAdapter()->query($query);
					}
				}
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
			if (!($itemId = $this->getRequest()->getParams('item_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (($item = Ccc::getModel('Item')->load($itemId))) {
				if (!$item->delete()) {
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