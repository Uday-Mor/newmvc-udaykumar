<?php
/**
 * 
 */
class Controller_Quote extends Controller_Core_Action
{
	public function quoteAction()
	{
		$layout = $this->getLayout();
		$layout->getChild('content')->addChild('quote',$layout->creatBlock('Quote_Quote'));
		$layout->render();
	}

	public function getCustomerAction()
	{
		if (!($customerId = $this->getRequest()->getPost('customer_id'))) {
			$this->redirect('quote');
		}

		$quote = Ccc::getModel('Quote')->getQuote();
		// $quote->load($customerId,'customer_id');

		$quote->customer_id = $customerId;
		if (!($insertId = $quote->save())) {
			$this->errorAction('Data not saved !!!');
		}
		$this->getSession()->set('customer_id',$customerId);
		Ccc::log($quote);
		$this->redirect('quote');
	}

	public function saveAddressAction()
	{
		try {
			if (!($this->getRequest()->isPost())) {
				$this->errorAction('Data not posted !!!');
			}

			if (!($addresses = $this->getRequest()->getPost())) {
				$this->errorAction('Data not found !!!');
			}

			$quote = Ccc::getModel('Quote')->getQuote();
			if (!($billingAddress = Ccc::getModel('Quote_Address')->load($quote->billing_address_id))) {
				$billingAddress = Ccc::getModel('Quote_Address');
			}

			if (!($shippingAddress = Ccc::getModel('Quote_Address')->load($quote->shipping_address_id))) {
				$shippingAddress = Ccc::getModel('Quote_Address');
			}

			$billingAddress->setData($addresses['billingAddress']);
			$billingAddress->quote_id = $quote->quote_id;
			$billingAddress->customer_address_id = $quote->getCustomer()->billing_address_id;
			$shippingAddress->quote_id = $quote->quote_id;
			$shippingAddress->customer_address_id = $quote->getCustomer()->shipping_address_id;
			if (array_key_exists('sameAddress',$addresses)) {
				$shippingAddress->setData($addresses['billingAddress']);
			}else{
				$shippingAddress->setData($addresses['shippingAddress']);
			}

			if (!($billingAddressId = $billingAddress->save()) || !($shippingAddressId = $shippingAddress->save())) {
				$this->errorAction('Data not saved !!!');
			}

			if (!$billingAddress->address_id) {
				$billingAddress->address_id = $billingAddressId;
			}

			if (!$shippingAddress->address_id) {
				$shippingAddress->address_id = $shippingAddressId;
			}

			$quote->billing_address_id = $billingAddress->address_id;
			$quote->shipping_address_id = $shippingAddress->address_id;

			if (!($quote->save())) {
				$this->errorAction('Data not saved !!!');
			}
			
			$this->redirect('quote');
		} catch (Exception $e) {
			
		}
	}

	public function savePaymentMethodAction()
	{
		try {
			if (!($this->getRequest()->isPost())) {
				$this->errorAction('Data not posted !!!');
			}

			if (!($paymentId = $this->getRequest()->getPost('payment_id'))) {
				$this->redirect('quote');
			}

			$quote = Ccc::getModel('Quote')->getQuote();
			$quote->payment_id = $paymentId;
			if (!($quote->save())) {
				$this->errorAction('Data not saved !!!');
			}

			$this->redirect('quote');
		} catch (Exception $e) {
			
		}
	}

	public function saveShippingMethodAction()
	{
		try {
			if (!($this->getRequest()->isPost())) {
				$this->errorAction('Data not posted !!!');
			}

			if (!($shippingId = $this->getRequest()->getPost('shipping_id'))) {
				$this->redirect('quote');
			}

			$quote = Ccc::getModel('Quote')->getQuote();
			$quote->shipping_id = $shippingId;
			if (!($quote->save())) {
				$this->errorAction('Data not saved !!!');
			}

			$this->redirect('quote');
		} catch (Exception $e) {
			
		}
	}

	public function addItemsAction()
	{
		try {
			if (!($this->getRequest()->isPost())) {
				$this->errorAction('Data not posted !!!');
			}

			if (!($items = $this->getRequest()->getPost('items'))) {
				$this->redirect('quote');
			}

			$quote = Ccc::getModel('Quote')->getQuote();
			foreach ($items as $productId) {
				$product = Ccc::getModel('Product')->load($productId);
				if (($item = Ccc::getModel('Quote_Item')->load($productId,'product_id'))) {
					$item->quantity = $item->quantity + 1;
				}else{
					$item = Ccc::getModel('Quote_Item');
					$item->quantity = 1;
					$item->product_id = $product->getId();
					$item->name = $product->sku_id;
					$item->price = $product->price;
					$item->quote_id = $quote->getId();
				}

				if (!$item->save()) {
					$this->errorAction('Data not saved !!!');
				}
			}
			
			$this->redirect('quote');
		} catch (Exception $e) {
			
		}
	}

	public function removeItemAction()
	{
		try {
			if (!($itemId = $this->getRequest()->getParams('item_id'))) {
				$this->errorAction('Invalid request !!!');
			}

			if (($item = Ccc::getModel('Quote_Item')->load($itemId))) {
				if (!($item->delete())) {
					$this->errorAction('Failed to delete data !!!');
				}
			}

			$this->redirect('quote',null,[],true);
		} catch (Exception $e) {
			
		}
	}

	public function saveItemsAction()
	{
		try {
			if (!($this->getRequest()->isPost())) {
				$this->errorAction('Data not posted !!!');
			}

			if (!($items = $this->getRequest()->getPost('item'))) {
				$this->redirect('quote');
			}

			foreach ($items as $itemId => $itemData) {
				if (!($item = Ccc::getModel('Quote_Item')->load($itemId))) {
					$this->errorAction('Invalid request !!!');
				}

				$item->quantity = $itemData['quantity'];
				if (!($item->save())) {
					$this->errorAction('Invalid request !!!');
				}
			}

			$this->redirect('quote');
		} catch (Exception $e) {
			
		}
	}
}