<?php
/**
 * 
 */
class Block_Product_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Products');
	}

	public function getCollection()
	{
		$query = "SELECT COUNT(`product_id`) FROM `product`";
		$records = Ccc::getModel('Core_Adapter')->fetchOne($query);
		$this->getPager($records,$this->getData('pg'));
		$this->getPager(10,10)->setRecordPerPage($this->getData('rpp'));
		$query = "SELECT * FROM `product` LIMIT {$this->getPager(10,10)->recordPerPage} OFFSET {$this->getPager(10,10)->startLimit};";
		$products = Ccc::getModel('Product')->fetchAll($query);
		return $products;
	}

	public function _prepareColumns()
	{
		$this->addColumn('product_id',[
			'title'=>'Product Id'
		]);
		$this->addColumn('sku_id',[
			'title'=>'SKU Id'
		]);
		$this->addColumn('cost',[
			'title'=>'Cost'
		]);
		$this->addColumn('price',[
			'title'=>'Price'
		]);
		$this->addColumn('quantity',[
			'title'=>'Quantity'
		]);
		$this->addColumn('description',[
			'title'=>'Description'
		]);
		$this->addColumn('status',[
			'title'=>'Status'
		]);
		$this->addColumn('color',[
			'title'=>'Color'
		]);
		$this->addColumn('material',[
			'title'=>'Material'
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
		$this->addAction('images',[
			'title'=>'Show Images',
			'method'=> 'getImageUrl'
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

	public function getImageUrl($row)
	{
		return $this->getUrl('grid','product_media',['product_id'=>$row->product_id]);
	}

	public function getEditUrl($row)
	{
		return $this->getUrl('edit',null,['product_id'=>$row->product_id]);
	}

	public function getDeleteUrl($row)
	{
		return $this->getUrl('delete',null,['product_id'=>$row->product_id]);
	}
}