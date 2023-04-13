<?php
/**
 * 
 */
class Block_Payment_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Payments');
	}

	public function _prepareColumns()
	{
		$this->addColumn('payment_id',[
			'title'=>'Payment Id'
		]);
		$this->addColumn('name',[
			'title'=>'Name'
		]);
		$this->addColumn('status',[
			'title'=>'Status'
		]);
		$this->addColumn('created_at',[
			'title'=>'Created At'
		]);
		$this->addColumn('updated_at',[
			'title'=>'Updated At'
		]);
	}

	public function _prepareActions()
	{
		$this->addAction('edit',[
			'title'=>'EDIT',
			'method'=> 'getEditUrl'
		]);
		$this->addAction('delete',[
			'title'=>'DELETE',
			'method'=> 'getDeleteUrl'
		]);
	}

	public function _prepareButtons()
	{
		$this->addButton('add',[
			'title'=>'Add Payment',
			'url'=>$this->getUrl('add')
		]);
	}

	public function getCollection()
	{
		$query = 'SELECT * FROM `payment`';
		$payments = Ccc::getModel('Payment')->fetchAll($query);
		return $payments;
	}

	public function getColumnValue($key,$row)
	{
		if ($key == 'status') {
			return $row->getStatusText();
		}
		return $row->$key;
	}

	public function getEditUrl($row)
	{
		return $this->getUrl('edit',null,['payment_id'=>$row->payment_id]);
	}

	public function getDeleteUrl($row)
	{
		return $this->getUrl('delete',null,['payment_id'=>$row->payment_id]);
	}
}