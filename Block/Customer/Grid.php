<?php
/**
 * 
 */
class Block_Customer_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Customers');
	}

	public function getCollection()
	{
		$query = "SELECT COUNT(`customer_id`) FROM `customer`";
		$records = Ccc::getModel('Core_Adapter')->fetchOne($query);
		$pager = $this->getPager($records,$this->getData('pg'));
		$query = "SELECT * FROM `customer` LIMIT {$pager->recordPerPage} OFFSET {$pager->startLimit};";
		$customeres = Ccc::getModel('Customer')->fetchAll($query);
		return $customeres;
	}

	public function _prepareColumns()
	{
		$this->addColumn('customer_id',[
			'title'=>'Customer Id'
		]);
		$this->addColumn('first_name',[
			'title'=>'First Name'
		]);
		$this->addColumn('last_name',[
			'title'=>'Last Name'
		]);
		$this->addColumn('email',[
			'title'=>'E-mail'
		]);
		$this->addColumn('mobile',[
			'title'=>'Mobile'
		]);
		$this->addColumn('gender',[
			'title'=>'Gender'
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
		$this->addAction('address',[
			'title'=>'Show Addresses',
			'method'=> 'getAddressUrl'
		]);
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
			'title'=>'Add Customer',
			'url'=>$this->getUrl('add')
		]);
	}

	public function getColumnValue($key,$row)
	{
		if ($key == 'status') {
			return $row->getStatusText();
		}
		return $row->$key;
	}

	public function getAddressUrl($row)
	{
		return $this->getUrl('address',null,['customer_id'=>$row->customer_id]);
	}

	public function getEditUrl($row)
	{
		return $this->getUrl('edit',null,['customer_id'=>$row->customer_id]);
	}

	public function getDeleteUrl($row)
	{
		return $this->getUrl('delete',null,['customer_id'=>$row->customer_id]);
	}
}