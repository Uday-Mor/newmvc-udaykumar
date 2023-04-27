<?php
/**
 * 
 */
class Controller_Category extends Controller_Core_Action
{
	public function indexAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('index',$layout->creatBlock('Core_Layout')->setTemplate('category/index.phtml'));
		echo $layout->toHtml();
	}

	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			if (!($pageNumber = $this->getRequest()->getParams('pg'))) {
				$pageNumber = 1;
			}
			$grid = $layout->creatBlock('Category_Grid')->setData(['pg'=>$pageNumber]);
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			if (!($category = Ccc::getModel('Category'))) {
				$this->errorAction('Request denied!!!');
			}

			$layout = $this->getLayout();
			$add = $layout->creatBlock('Category_Edit');
			$response = $add->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function editAction()
	{
		try {
			if (!($categoryId = (int) $this->getRequest()->getParams('category_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!($category = Ccc::getModel('Category')->load($categoryId))) {
				$this->errorAction('Failed to fetch data!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Category_Edit');
			$edit->setData(['category'=>$category]);
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
				$this->errorAction('Invalid request!!!');
			}

			if (!($postData = $this->getRequest()->getPost('category'))) {
				$this->errorAction('Data is not posted!!!');
			}

			$category = Ccc::getModel('Category');
			if (($categoryId = (int) $this->getRequest()->getParams('category_id'))) {
				if(!($category->load($categoryId))) {
					$this->errorAction('Data not found!!!');
				}
			}

			if ($category->category_id) {
				$category->updated_at = date("Y-m-d h:i:sa");
			}else{
				$category->created_at = date("Y-m-d h:i:sa");
			}

			$category->setData($postData);
			if (!($insertId = $category->save())) {
				$this->errorAction('Data not saved!!!');
			}

			if(!$category->category_id){
				$category->category_id = $insertId;
			}

			$attributePostData = $this->getRequest()->getPost('attribute');
			if ($attributePostData) {
				foreach ($attributePostData as $backendType => $attributes) {
					foreach ($attributes as $attributeId => $value) {
						if(is_array($value)){
							$value = implode(",", $value);
						}

						$model = Ccc::getModel("Core_Table");
						$model->getResource()->setTableName("category_{$backendType}")->setPrimaryKey('value_id');
						$query = "INSERT INTO `category_{$backendType}` (`entity_id`,`attribute_id`,`value`) VALUES ('{$category->getId()}','{$attributeId}','{$value}') ON DUPLICATE KEY UPDATE `value` = '{$value}'";
						$model->getResource()->getAdapter()->query($query);
					}
				}
			}

			$category->updatePath();
			$this->getMessage()->addMessage('Data saved successfully!!!');
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Category_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}	
	}

	public function deleteAction()
	{
		try {
			if (!($categoryId = $this->getRequest()->getParams('category_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (($category = Ccc::getModel('Category')->load($categoryId))) {
				$query = "DELETE FROM `category` WHERE `path` LIKE '{$category->path}%'";
				if (!(Ccc::getModel('Core_Adapter')->delete($query))) {
					$this->errorAction('Failed delete data!!!');
				}
			}

			$this->getMessage()->addMessage('Data deleted successfully!!!');
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Category_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
}