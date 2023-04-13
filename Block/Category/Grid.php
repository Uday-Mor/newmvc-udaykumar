<?php
/**
 * 
 */
class Block_Category_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Categories');
	}

	public function getCollection()
	{
		$query = 'SELECT * FROM `category` WHERE `parent_id` IS NOT NULL ORDER BY `path` ASC';
		$categories = Ccc::getModel('Category')->fetchAll($query);
		return $categories;
	}

	public function _prepareColumns()
	{
		$this->addColumn('category_id',[
			'title'=>'Category Id'
		]);
		$this->addColumn('parent_id',[
			'title'=>'Parent Id'
		]);
		$this->addColumn('path',[
			'title'=>'Name'
		]);
		$this->addColumn('name',[
			'title'=>'Name'
		]);
		$this->addColumn('status',[
			'title'=>'Status'
		]);
		$this->addColumn('description',[
			'title'=>'Description'
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
			'title'=>'Add Category',
			'url'=>$this->getUrl('add')
		]);
	}

	public function getColumnValue($key,$row)
	{
		if ($key == 'status') {
			return $row->getStatusText();
		}
		if ($key == 'path') {
			return $row->getPathName();
		}
		return $row->$key;
	}

	public function getEditUrl($row)
	{
		return $this->getUrl('edit',null,['category_id'=>$row->category_id]);
	}

	public function getDeleteUrl($row)
	{
		return $this->getUrl('delete',null,['category_id'=>$row->category_id]);
	}


}