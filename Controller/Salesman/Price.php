<?php 
/**
 * 
 */
class Controller_Salesman_Price extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$request = $this->getRequest();
			if (!($salesmanId = $request->getParams('salesman_id'))) {
				$this->errorAction('Invalid request !!!');
			}
			

			$layout = $this->getLayout();
			$layout->getChild('content')->addChild('grid',$layout->creatBlock('Salesman_Price_Grid'));
			$layout->render();
			// $this->getView()->setData(['salesman'=>$salesmen,'salesman_prices'=>$salesman_prices])->setTemplate('salesman_price/grid.phtml');
			// $this->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getmessage(),'failure');
			$this->redirect('grid','product',null,true);
		}
	}
	
	public function updateAction()
	{
		try {
			$request = $this->getRequest();
			$salesmanId = $request->getParams('salesman_id');
			if (!$request->isPost() || !$salesmanId) {
				$this->errorAction('Invalid request !!!');
			}

			$changed_prices = $request->getPost('salesman_price');
			foreach ($changed_prices as $key => $value) {
				$search_query = 'SELECT `entity_id` FROM `salesman_price` WHERE `product_id` = '.$key.' AND `salesman_id` = '.$salesmanId.'';
				$price = Ccc::getModel('Salesman_Price')->fetchRow($search_query);
				if ($price) 
				{
					$data = ['entity_id'=>$price->entity_id,'salesman_price'=>$value];
					$price->setData($data);
					$result = $price->save();
					if (!$result) {
						$this->errorAction('Failed to update price !!!');
					}
				}else{
					if ($value != '') {
						$data = ['salesman_price'=>$value,'product_id'=>$key,'salesman_id'=>$salesmanId];
						$price = Ccc::getModel('Salesman_Price')->setData($data);
						$result = $price->save();
						if (!$result) {
							$this->errorAction('Failed to update price !!!');
						}
					}
				}
			}

			$this->getMessage()->addMessage('Price Updated Successfully..!!');
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
			$entityId = $request->getParams('entity_id');
			if (!$entityId) {
				$this->errorAction('Invalid request !!!');
			}

			$rowModel = Ccc::getModel('Salesman_Price');
			$rowModel->entity_id = $entityId;
			$result = $rowModel->delete();
			if (!$result) {
				$this->errorAction('Failed to delete salesman price');
			}

			$this->getMessage()->addMessage('Price Deleted Successfully..!!');
			$this->redirect('grid',null,['entity_id'=>null]);
		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getmessage(),'failure');
			$this->redirect('grid',null,null,true);
		}
	}
}
?>