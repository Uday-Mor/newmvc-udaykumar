<?php
/**
 * 
 */
class Controller_Brand extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('grid',$layout->creatBlock('Brand_Grid'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			if (!($shipping = Ccc::getModel('Brand'))) {
				$this->errorAction('Request denied!!!');
			}

			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('edit',$layout->creatBlock('Brand_Edit'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}

	public function importAction()
	{
		try {
			$layout = $this->getLayout();
			$import = $layout->creatBlock('Core_Import');
			$response = $import->toHtml();
			$this->getResponse()->jsonResponse(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function importDataAction()
	{
		try {
			$upload = Ccc::getModel('Core_File_Upload');
			$upload->setPath('brand/csv')->setExtensions(['csv'])->upload('csv');
			$file = $upload->getFile();
			$rows = Ccc::getModel('Core_File_Csv')->setPath($upload->getPath())->setFileName($file['name'])->get();
			$brandModel = Ccc::getModel('brand');
			foreach ($rows as $row) {
				$uniqueColumns = ['name'=>$row['name']];
				$brandModel->getResource()->insertUpdateOnDuplicate($row,$uniqueColumns);
			}
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function exportAction()
	{	
		try {
			$sql = "SELECT * FROM `brand` ORDER BY `brand_id` DESC";
			$model = Ccc::getModel('brand');
			$data = $model->getResource()->fetchAll($sql);
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; var/brand/csv/brand.csv');
			$fp = fopen("php://output", "w");
			$header = [];
			foreach ($data as $row) {
				if (!$header) {
					$header = array_keys($row);
					fputcsv($fp, $header);
				}
				fputcsv($fp, $row);
			}

			fclose($fp);
		 } catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		 }
	}

	public function editAction()
	{
		try {
			if (!($brandId = $this->getRequest()->getParams('brand_id'))) {
				$this->errorAction('Invalid request!!!');
			}
			
			if (!($brand = Ccc::getModel('Brand')->load($brandId))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Brand_Edit');
			$edit->setData(['brand'=>$brand]);
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
				$this->errorAction('Data is not posted!!');
			}

			if (!($postData = $this->getRequest()->getPost('brand'))) {
				$this->errorAction('Data not found!!');
			}

			$brand = Ccc::getModel('Brand');
			if ($brandId = (int) $this->getRequest()->getParams('brand_id')) {
				if (!($brand = $brand->load($brandId))) {
					$this->errorAction('Data not found to update!!!');
				}
			}

			if ($brand->brand_id) {
				$brand->updated_at = date("Y-m-d h:i:sa");
			}else{
				$brand->created_at = date("Y-m-d h:i:sa");
			}

			$brand->setData($postData);
			if (!($insertId = $brand->save())) {
				$this->errorAction('Data not saved!!');
			}

			if (!$brand->brand_id) {
				$brand->brand_id = $insertId;
			}



			$attributePostData = $this->getRequest()->getPost('attribute');
			if ($attributePostData) {
				foreach ($attributePostData as $backendType => $attributes) {
					foreach ($attributes as $attributeId => $value) {
						if(is_array($value)){
							$value = implode(",", $value);
						}

						$model = Ccc::getModel("Core_Table");
						$model->getResource()->setTableName("brand_{$backendType}")->setPrimaryKey('value_id');
						$query = "INSERT INTO `brand_{$backendType}` (`brand_id`,`attribute_id`,`value`) VALUES ('{$brand->getId()}','{$attributeId}','{$value}') ON DUPLICATE KEY UPDATE `value` = '{$value}'";
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
			if (!($brandId = $this->getRequest()->getParams('brand_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!$brand = Ccc::getModel('Brand')->load($brandId)) {
				$this->errorAction('Data not found!!!');
			}

			if (!$brand->delete()) {
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


