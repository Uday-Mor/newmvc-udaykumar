<?php
/**
 * 
 */
class Block_Salesman_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Salesmen');
	}

	public function getCollection()
	{
		$query = 'SELECT * FROM `salesman`';
		$salesmen = Ccc::getModel('Salesman')->fetchAll($query);
		return $salesmen;
	}

	public function _prepareColumns()
	{
		$this->addColumn('salesman_id',[
			'title'=>'Salesman Id'
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
		$this->addAction('prices',[
			'title'=>'Show Prices',
			'method'=> 'getPriceUrl'
		]);
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

	public function getPriceUrl($row)
	{
		return $this->getUrl('grid','salesman_price',['salesman_id'=>$row->salesman_id]);
	}

	public function getAddressUrl($row)
	{
		return $this->getUrl('address',null,['salesman_id'=>$row->salesman_id]);
	}

	public function getEditUrl($row)
	{
		return $this->getUrl('edit',null,['salesman_id'=>$row->salesman_id]);
	}

	public function getDeleteUrl($row)
	{
		return $this->getUrl('delete',null,['salesman_id'=>$row->salesman_id]);
	}
}