<?php
/**
 * 
 */
class Controller_Eav_Attribute extends Controller_Core_Action
{
	public function indexAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('index',$layout->creatBlock('Core_Layout')->setTemplate('core/index.phtml'));
		$this->renderLayout();
	}

	public function gridAction()
	{
		$layout = $this->getLayout();
		if (!($pageNumber = $this->getRequest()->getParams('pg'))) {
			$pageNumber = 1;
		}
		$grid = $layout->creatBlock('Eav_Attribute_Grid')->setData(['pg'=>$pageNumber]);
		$response = $grid->toHtml();
		$this->getResponse()->jsonResponse(['element'=>'content','html'=>$response]);
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$add = $layout->creatBlock('Eav_Attribute_Edit');
			$response = $add->toHtml();
			$this->getResponse()->jsonResponse(['element'=>'content','html'=>$response]);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
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
			$response = $edit->toHtml();
			$this->getResponse()->jsonResponse(['element'=>'content','html'=>$response]);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
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

			if ($postData['input_type'] == 'text' || $postData['input_type'] == 'textBox') {
				unset($postData['option']);
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

			if ($postData['input_type'] == 'text' || $postData['input_type'] == 'textBox') {
				$query = 'DELETE FROM `eav_attribute_option` WHERE `attribute_id` = "'.$attributeId.'"';
				if (!($result = Ccc::getModel('Core_Adapter')->delete($query))) {
					$this->errorAction('Failed to delete option Data');
				}
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
			$layout = $this->getLayout();
			$response = $layout->creatBlock('Eav_Attribute_Grid')->toHtml();
			$this->getResponse()->jsonResponse(['element'=>'content','html'=>$response]);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
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
			$layout = $this->getLayout();
			$response = $layout->creatBlock('Eav_Attribute_Grid')->toHtml();
			$this->getResponse()->jsonResponse(['element'=>'content','html'=>$response]);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
}