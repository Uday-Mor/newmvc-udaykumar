<?php
/**
 * 
 */
class Block_Product_Media_Grid extends Block_Core_Grid
{

	protected $product = null;

	public function getProduct()
	{
		return $this->product;
	}

	public function setProduct($product)
	{
		$this->product = $product;
	}

	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Product Images');
	}

	public function getCollection()
	{
		$productId = Ccc::getModel('Core_Request')->getParams('product_id');
		$product = Ccc::getModel('Product')->load($productId);
		$this->setProduct($product);
		return $product->getImages();
	}

	public function _prepareColumns()
	{
		$this->addColumn('image_id',[
			'title'=>'Image Id'
		]);
		$this->addColumn('product_id',[
			'title'=>'Product Id'
		]);
		$this->addColumn('name',[
			'title'=>'Name'
		]);
		$this->addColumn('image',[
			'title'=>'Image'
		]);
		$this->addColumn('base',[
			'title'=>'Base'
		]);
		$this->addColumn('thumbnail',[
			'title'=>'Thumbnail'
		]);
		$this->addColumn('small',[
			'title'=>'Small'
		]);
		$this->addColumn('gallary',[
			'title'=>'Gallary'
		]);
		$this->addColumn('file_name',[
			'title'=>'File Name'
		]);
		$this->addColumn('created_at',[
			'title'=>'Created At'

		]);
	}
	public function _prepareActions()
	{
		$this->addAction('delete',[
			'title'=>'DELETE',
			'method'=>'getDeleteUrl'
		]);
	}

	public function _prepareButtons()
	{
		$this->addButton('add',[
			'title'=>'Add Image',
			'url'=> $this->getUrl('add')
		]);
	}

	public function getColumnValue($key,$row)
	{
		if ($key == 'base') {
			$checked = ($row->image_id == $this->getProduct()->getBase()) ? 'checked' : '';
			return '<input type="radio" name="base" value='.$row->image_id.' '.$checked.'>';
		}

		if ($key == 'thumbnail') {
			$checked = ($row->image_id == $this->getProduct()->getThumnail()) ? 'checked' : '';
			return '<input type="radio" name="thumbnail" value='.$row->image_id.' '.$checked.'>';
		}

		if ($key == 'small') {
			$checked = ($row->image_id == $this->getProduct()->getSmall()) ? 'checked' : '';
			return '<input type="radio" name="small" value='.$row->image_id.' '.$checked.'>';
		}

		return $row->$key;
	}

	public function getDeleteUrl($row)
	{
		return $this->getUrl('delete',null,['image_id'=>$row->image_id],true);
	}
}