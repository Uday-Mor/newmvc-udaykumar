<?php
/**
 * 
 */
class Controller_Product extends Controller_Core_Action
{

	public function indexAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('index',$layout->creatBlock('Core_Layout')->setTemplate('core/index.phtml'));
		$this->renderLayout();
	}

	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$pageNumber = (int) $this->getRequest()->getParams('pg',1);
			$recordPerPage = (int) $this->getRequest()->getParams('rpp',10);
			$grid = $layout->creatBlock('Product_Grid')->setData(['pg'=>$pageNumber,'rpp'=>$recordPerPage]);
			$response = $grid->toHtml();
			$this->getResponse()->jsonResponse(['html'=>$response,'element'=>'content']);
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
			$add = $layout->creatBlock('Product_Edit');
			$response = $add->toHtml();
			$this->getResponse()->jsonResponse(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function importAction()
	{
		try {
			$layout = $this->getLayout();
			$import = $layout->creatBlock('Product_Import');
			$response = $import->toHtml();
			$this->getResponse()->jsonResponse(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function importProductAction()
	{
		try {
			echo "<pre>";

			$upload = Ccc::getModel('Core_File_Upload');
			$upload->setPath('product/csv')->setExtensions(['csv'])->upload('csv');
			$file = $upload->getFile();
			$rows = Ccc::getModel('Core_File_Csv')->setPath($upload->getPath())->setFileName($file['name'])->get();
			$productModel = Ccc::getModel('Product');
			foreach ($rows as $row) {
				print_r($row);
				var_dump($row["sku_id"]);
				$uniqueColumns = ['sku_id'=>$row['sku_id']];
				$productModel->getResource()->insertUpdateOnDuplicate($row,$uniqueColumns);
			}
		} catch (Exception $e) {
			
		}
	}

	public function exportAction()
	{	
		try {
			$sql = "SELECT * FROM `product` ORDER BY `product_id` DESC";
			$model = Ccc::getModel('Product');
			$data = $model->getResource()->fetchAll($sql);
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; var/product/csv/product.csv');
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
		 	
		 } 
print_r(expression);



		$fields = ['product_id','name','sku','cost','price','description','status','color','material','thumbnail','small','base','created_at','updated_at']; 
		// echo $fields; die;
		fputcsv($file, $fields, ',');

		print_r($data[0]);
		if($data->count() > 0){ 
		    // while($row = $data->getData()){ 
		    //     // $lineData = array($row['id'], $row['name'], $row['email'], $row['phone'], $row['created'], $row['status']); 
		    //     fputcsv($file, $row, $delimiter); 
		    // }
		    foreach ($data->getData() as $value) {
		        fputcsv($file, $value, ','); 
		     } 
		} 
		 
		// Move back to beginning of file 
		fseek($file, 0); 
		 
		// Set headers to download file rather than displayed 
		@header('Content-Type: text/csv'); 
		@header('Content-Disposition: attachment; filename="' . $filename . '";'); 
		 
		// Output all remaining data on a file pointer 
		fpassthru($file); 
		 
		// Exit from file 
		exit();
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
			$edit = $layout->creatBlock('Product_Edit');
			$edit->setData(['product'=>$product]);
			$response = $edit->toHtml();
			$this->getResponse()->jsonResponse(['html'=>$response,'element'=>'content']);
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

			if (!($postData = $this->getRequest()->getPost('product'))) {
				$this->errorAction('Data is not found!!!');
			}

			$product = Ccc::getModel('Product');
			if ($productId = $this->getRequest()->getParams('product_id')) {
				if (!($product = $product->load($productId))) {
					$this->errorAction('Failed to fetch data!!!');
				}

				unset($product->base);
				unset($product->small);
				unset($product->thumnail);
			}
			
			if ($product->product_id) {
				$product->updated_at = date("Y-m-d h:i:sa");
			}else{
				$product->created_at = date("Y-m-d h:i:sa");
			}

			$product->setData($postData);
			if (!($insertId = $product->save())) {
				$this->errorAction('Failed to save Data!!!');
			}

			if (!$product->product_id) {
				$product->product_id = $insertId;
			}

			$attributePostData = $this->getRequest()->getPost('attribute');
			if ($attributePostData) {
				foreach ($attributePostData as $backendType => $attributes) {
					foreach ($attributes as $attributeId => $value) {
						if(is_array($value)){
							$value = implode(",", $value);
						}

						$model = Ccc::getModel("Core_Table");
						$model->getResource()->setTableName("product_{$backendType}")->setPrimaryKey('value_id');
						$query = "INSERT INTO `product_{$backendType}` (`entity_id`,`attribute_id`,`value`) VALUES ('{$product->getId()}','{$attributeId}','{$value}') ON DUPLICATE KEY UPDATE `value` = '{$value}'";
						$model->getResource()->getAdapter()->query($query);
					}
				}
			}

			$this->getMessage()->addMessage('Data saved successfully!!!');
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Product_Grid');
			$response = $grid->toHtml();
			$this->getResponse()->jsonResponse(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
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
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Product_Grid');
			$response = $grid->toHtml();
			$this->getResponse()->jsonResponse(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage,Model_Core_Message::FAILURE);
			$this->redirect('grid',null,[],true);
		}
	}
}