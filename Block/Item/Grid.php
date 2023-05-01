<?php
/**
 * 
 */
class Block_Item_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Items');
	}

	public function getCollection()
	{
		$query = 'SELECT * FROM `item`';
		$items = Ccc::getModel('Item')->fetchAll($query);
		return $items;
	}

	public function _prepareColumns()
	{
		$this->addColumn('item_id',[
			'title'=>'Item Id'
		]);
		$this->addColumn('sku',[
			'title'=>'SKU'
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
			'title'=>'Add Item',
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
		return $this->getUrl('edit',null,['item_id'=>$row->item_id]);
	}

	public function getDeleteUrl($row)
	{
		return $this->getUrl('delete',null,['item_id'=>$row->item_id]);
	}
}