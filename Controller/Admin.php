<?php
/**
 * 
 */
class Controller_Admin extends Controller_Core_Action
{
	public function indexAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('index',$layout->creatBlock('Core_Layout')->setTemplate('admin/index.phtml'));
		echo $layout->toHtml();
	}

	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			if (!($pageNumber = $this->getRequest()->getParams('pg'))) {
				$pageNumber = 1;
			}
			$grid = $layout->creatBlock('Admin_Grid')->setData(['pg'=>$pageNumber]);
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			if (!($admin = Ccc::getModel('Admin'))) {
				$this->errorAction('Request denied!!!');
			}

			$layout = $this->getLayout();
			$add = $layout->creatBlock('Admin_Edit');
			$response = $add->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
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
			$upload->setPath('admin/csv')->setExtensions(['csv'])->upload('csv');
			$file = $upload->getFile();
			$rows = Ccc::getModel('Core_File_Csv')->setPath($upload->getPath())->setFileName($file['name'])->get();
			$adminModel = Ccc::getModel('Admin');
			foreach ($rows as $row) {
				$uniqueColumns = ['email'=>$row['email']];
				$adminModel->getResource()->insertUpdateOnDuplicate($row,$uniqueColumns);
			}
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function exportAction()
	{	
		try {
			$sql = "SELECT * FROM `admin` ORDER BY `admin_id` DESC";
			$model = Ccc::getModel('Admin');
			$data = $model->getResource()->fetchAll($sql);
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; var/admin/csv/admin.csv');
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
			if (!($adminId = $this->getRequest()->getParams('admin_id'))) {
				$this->errorAction('Invalid request!!!');
			}
			
			if (!($admin = Ccc::getModel('Admin')->load($adminId))) {
				$this->errorAction('Data not found!!!');
			}

			$layout = $this->getLayout();
			$edit = $layout->creatBlock('Admin_Edit');
			$edit->setData(['admin'=>$admin]);
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
				$this->errorAction('Data is not posted!!');
			}

			if (!($postData = $this->getRequest()->getPost('admin'))) {
				$this->errorAction('Data not found!!');
			}

			$admin = Ccc::getModel('Admin');
			if ($adminId = (int) $this->getRequest()->getParams('admin_id')) {
				if (!($admin = $admin->load($adminId))) {
					$this->errorAction('Data not found to update!!!');
				}
			}

			if ($admin->admin_id) {
				$admin->updated_at = date("Y-m-d h:i:sa");
			}else{
				$admin->created_at = date("Y-m-d h:i:sa");
			}

			$admin->setData($postData);
			if (!($admin->save())) {
				$this->errorAction('Data not saved!!');
			}

			$this->getMessage()->addMessage('Data saved successfully!!!');
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Admin_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function deleteAction()
	{
		try {
			if (!($adminId = $this->getRequest()->getParams('admin_id'))) {
				$this->errorAction('Invalid request!!!');
			}

			if (!$admin = Ccc::getModel('Admin')->load($adminId)) {
				$this->errorAction('Data not found!!!');
			}

			if (!$admin->delete()) {
				$this->errorAction('Failed to delete data!!!');
			}

			$this->getMessage()->addMessage('Data deleted successfully!!!');
			$layout = $this->getLayout();
			$grid = $layout->creatBlock('Admin_Grid');
			$response = $grid->toHtml();
			echo json_encode(['html'=>$response,'element'=>'content']);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
}