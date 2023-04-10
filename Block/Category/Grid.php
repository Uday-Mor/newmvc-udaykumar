<?php
/**
 * 
 */
class Block_Category_Grid extends Block_Core_Templates
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('category/grid.phtml');
	}

	public function prepareData()
	{
		$query = 'SELECT * FROM `category` WHERE `parent_id` IS NOT NULL ORDER BY `path` ASC';
		$categories = Ccc::getModel('Category')->fetchAll($query);
		return $categories;
	}
}