<?php
/**
 * 
 */
class Block_Brand_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Brands');
	}

	public function getCollection()
	{
		$query = 'SELECT * FROM `brand`';
		$brands = Ccc::getModel('Brand')->fetchAll($query);
		return $brands;
	}

	public function _prepareColumns()
	{
		$this->addColumn('brand_id',[
			'title'=>'Brand Id'
		]);
		$this->addColumn('name',[
			'title'=>'Name'
		]);
		$this->addColumn('discription',[
			'title'=>'Discription'
		]);
		$this->addColumn('image',[
			'title'=>'Image'
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
			'title'=>'Add Brand',
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
		return $this->getUrl('edit',null,['brand_id'=>$row->brand_id]);
	}

	public function getDeleteUrl($row)
	{
		return $this->getUrl('delete',null,['brand_id'=>$row->brand_id]);
	}
}