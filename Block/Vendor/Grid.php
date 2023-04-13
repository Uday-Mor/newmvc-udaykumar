<?php
/**
 * 
 */
class Block_Vendor_Grid extends Block_Core_Grid
{
	function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Vendors');
	}

	public function getCollection()
	{
		$query = 'SELECT * FROM `vendor`';
		$vendors = Ccc::getModel('Vendor')->fetchAll($query);
		return $vendors;
	}

	public function _prepareColumns()
	{
		$this->addColumn('vendor_id',[
			'title'=>'Vendor Id'
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
		$this->addColumn('company',[
			'title'=>'Company'
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
			'title'=>'Add Product',
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
		return $this->getUrl('address',null,['vendor_id'=>$row->vendor_id]);
	}

	public function getEditUrl($row)
	{
		return $this->getUrl('edit',null,['vendor_id'=>$row->vendor_id]);
	}

	public function getDeleteUrl($row)
	{
		return $this->getUrl('delete',null,['vendor_id'=>$row->vendor_id]);
	}
}