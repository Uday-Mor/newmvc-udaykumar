<?php 
/**
 * 
 */
class Controller_Product_Media extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$request = $this->getRequest();
			$productId = $request->getParams('product_id');
			if (!$productId) {
				$this->errorAction('Invalid request !!!');
			}
			
			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('grid',$layout->creatBlock('Product_Media_Grid'));
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getmessage(),'failure');
			$this->redirect('grid','product',[],true);
		}
	}
	
	public function addAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('add',$layout->creatBlock('Product_Media_Add'));
		$layout->render();
	}
	
	public function insertAction()
	{
		try {
			$request = $this->getRequest();
			$productId = $request->getParams('product_id');
			if (!$request->isPost() || !$productId) {
				$this->errorAction('Invalid request !!!');
			}

			$name = $request->getPost('name'); 
			$rowModel = Ccc::getModel('Product_Media')->setData([]);
			$rowModel->name = $name;
			$rowModel->product_id = $productId;
			$rowModel->created_at = date('Y-m-d h:i:sa');
			$insertedId = $rowModel->save();

			// upload file into folder
			$target_dir = "View/product/media/Images/";
			$extension = explode('.',$_FILES["image"]["name"]);
			$fileName = $insertedId.'.'.$extension[1];
			$target_file = $target_dir . $fileName;
			$moveFile = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
			$filedata = ['file_name'=>$fileName];
			$rowModel->file_name = $fileName;
			$rowModel->image_id = $insertedId;
			$result = $rowModel->save();
			if (!$result) {
				$this->errorAction('Failed to update file name !!!');
			}

			$this->getMessage()->addMessage('Image Added Successfully..!!');
			$this->redirect('grid',null,null);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getmessage(),'failure');
			$this->redirect('grid',null,null,true);
		}
	}
	
	public function saveAction()
	{
		try {
			$request = $this->getRequest();
			$productId = $request->getParams('product_id');
			if (!$productId) {
				$this->errorAction('Invalid Request !!');
			}

			if (!($product = Ccc::getModel('Product')->load($productId))) {
				$this->errorAction('Product data not found !!!');
			}

			if (!$request->isPost()) {
				$this->errorAction('Invalid request !!!');
			}

			$data = $request->getPost();
			if (array_key_exists('base',$data)) {
				$product->base = $data["base"];
			}

			if (array_key_exists('thumnail',$data)) {	
				$product->thumnail = $data["thumnail"];
			}

			if (array_key_exists('small',$data)) {
				$product->small = $data["small"];
			}	

			if (!($product->save())) {
				$this->errorAction('failed to save data !!!');
			}

			if (array_key_exists('gallary',$data)) {
				$condition = $data["gallary"];
				$gallary = Ccc::getModel('Product_Media');
				$gallary->setData(['gallary'=>1]);
				$gallary->image_id = $imageId;
				$result = $gallary->save($condition);
				if (!$result) {
					$this->errorAction('failed to save data !!!');
				}
			}

			$this->getMessage()->addMessage('Data Saved Successfully..!!');
			$this->redirect('grid',null,null);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getmessage(),'failure');
			$this->redirect('grid',null,null,true);
		}
	}
	
	public function deleteAction()
	{
		try {
			$request = $this->getRequest();
			$imageId = $request->getParams('image_id');
			$productId = $request->getParams('product_id');
			if (!$productId || !$imageId) {
				$this->errorAction('Invalid request !!');
			}

			$rowModel = Ccc::getModel('Product_Media');
			$rowModel->image_id = $imageId; 		
			$result = $rowModel->delete();
			if (!$result) {
				$this->errorAction('Failed to delete image!!!');
			}
			$this->getMessage()->addMessage('Image Deleted Successfully..!!');
			$this->redirect('grid',null,null);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getmessage(),'failure');
			$this->redirect('grid',null,null,true);	
		}
	}
}

?>