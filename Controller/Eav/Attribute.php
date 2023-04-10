<?php
/**
 * 
 */
class Controller_Eav_Attribute extends Controller_Core_Action
{
	public function gridAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('grid',$layout->creatBlock('Eav_Attribute_Grid'));
		$layout->render();
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('edit',$layout->creatBlock('Eav_Attribute_Edit'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}

	public function editAction()
	{
		try {
			if (!($attributeId = $this->getRequest()->getParams('attribute_id'))) {
				$this->errorAction('Invalid request !!!');
			}

			if (!($attribute = Ccc::getModel('Eav_Attribute')->load($attributeId))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Eav_Attribute_Edit')->setData(['attribute'=>$attribute]);
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
			if (!($this->getRequest()->isPost())) {
				$this->errorAction('Invalid request !!!');
			}

			if (!($postData = $this->getRequest()->getPost('attribute'))) {
				$this->errorAction('Data is not posted !!!');
			}

			$existingOptions = null;
			$newOptions = null;
			if (array_key_exists('option',$postData)) {
				if (array_key_exists('exist',$postData['option'])) {
					$existingOptions = $postData['option']['exist'];
				}
				if (array_key_exists('new',$postData['option'])) {
					$newOptions = $postData['option']['new'];
				}
			}

			unset($postData['option']);
			$attribute = Ccc::getModel('Eav_Attribute');
			if ($attributeId = $this->getRequest()->getParams('attribute_id')) {
				if (!($attribute = $attribute->load($attributeId))) {
					$this->errorAction('Failed to fetch data!!!');
				}
			}

			$attribute->setData($postData);
			if (!($insertId = $attribute->save())) {
				$this->errorAction('Failed to save Data!!!');
			}

			if ($attribute->attribute_id) {
				$attributeId = $attribute->attribute_id;
			}else{
				$attributeId = $insertId;
			}

			$where = '';
			if ($existingOptions) {
				$where = 'AND `option_id` NOT IN ('.implode(',',array_keys($existingOptions)).')';
				foreach ($existingOptions as $optionId => $name) {
					if (!($option = Ccc::getModel('Eav_Attribute_Option')->load($optionId))) {
						$this->errorAction('Failed to load option Data');
					}
					$option->name = $name;
					if (!($option->save())) {
						$this->errorAction('Failed to save option Data');
					}
				}
			}

			$query = 'DELETE FROM `eav_attribute_option` WHERE `attribute_id` = "'.$attribute->attribute_id.'" '.$where;
			if (!($result = Ccc::getModel('Core_Adapter')->delete($query))) {
				$this->errorAction('Failed to delete option Data');
			}

			if ($newOptions) {
				foreach ($newOptions as $optionId => $name) {
					$option = Ccc::getModel('Eav_Attribute_Option');
					$option->name = $name;
					$option->attribute_id = $attributeId;
					if (!($option->save())) {
						$this->errorAction('Failed to save option Data');
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
			if (!($attributeId = $this->getRequest()->getParams('attribute_id'))) {
				$this->errorAction('Invalid request !!!');
			}

			if ($attribute = Ccc::getModel('Eav_Attribute')->load($attributeId)) {
				if (!$attribute->delete()) {
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