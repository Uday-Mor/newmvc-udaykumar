<?php
/**
 * 
 */
class Block_Shipping_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Shippings');
	}

	public function getCollection()
	{
		$query = "SELECT COUNT(`shipping_id`) FROM `shipping`";
		$records = Ccc::getModel('Core_Adapter')->fetchOne($query);
		$pager = $this->getPager($records,$this->getData('pg'));
		$query = "SELECT * FROM `shipping` LIMIT {$pager->recordPerPage} OFFSET {$pager->startLimit};";
		$shippings = Ccc::getModel('Shipping')->fetchAll($query);
		return $shippings;
}

	public function _prepareColumns()
	{
		$this->addColumn('shipping_id',[
			'title'=>'Shipping Id'
		]);
		$this->addColumn('name',[
			'title'=>'Name'
		]);
		$this->addColumn('amount',[
			'title'=>'Amount'
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
			'title'=>'Add Product',
			'url'=>$this->getUrl('add')
		]);
		$this->addButton('import',[
			'title'=>'Import',
			'url'=>$this->getUrl('import')
		]);
		$this->addButton('export',[
			'title'=>'Export',
			'url'=>$this->getUrl('export')
		]);
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
		return $this->getUrl('edit',null,['shipping_id'=>$row->shipping_id]);
	}

	public function getDeleteUrl($row)
	{
		return $this->getUrl('delete',null,['shipping_id'=>$row->shipping_id]);
	}
}