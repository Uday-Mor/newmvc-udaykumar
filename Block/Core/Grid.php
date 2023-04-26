<?php
/**
 * 
 */
class Block_Core_Grid extends Block_Core_Templates
{
	protected $columns = [];
	protected $actions = [];
	protected $buttons = [];
	protected $title = null;
	protected $pager = null;

	public function __construct()
	{
		$this->setTitle('Manage grid');
		$this->_prepareColumns();
		$this->_prepareActions();
		$this->_prepareButtons();
		$this->setTemplate('core/grid.phtml');
	}

	public function getPager($records,$currentPage)
	{
		if ($this->pager) {
			return $this->pager;
		}
		$pager = new Model_Core_Pager($records,$currentPage);
		$this->setPager($pager);
		return $pager;
	}

	public function setPager(Model_Core_Pager $pager)
	{
		$this->pager = $pager;
		return $this;
	}

	public function getColumns()
	{
		return $this->columns;
	}

	public function setColumns(array $columns)
	{
		$this->columns = $columns;
		return $this;
	}

	public function addColumn($key,$value)
	{
		$this->columns[$key] = $value;
		return $this;
	}

	public function removeColumn($key)
	{
		if (array_key_exists($key,$this->columns)) {
			unset($this->columns[$key]);
		}
		return $this;
	}

	public function getColumn($key)
	{
		if (array_key_exists($key,$this->columns)) {
			return $this->columns[$key];
		}
	}

	public function _prepareColumns()
	{
		return $this;
	}

	public function getActions()
	{
		return $this->actions;
	}

	public function setActions(array $actions)
	{
		$this->actions = $actions;
		return $this;
	}

	public function addAction($key,$value)
	{
		$this->actions[$key] = $value;
		return $this;
	}

	public function removeAction($key)
	{
		if (array_key_exists($key,$this->actions)) {
			unset($this->actions[$key]);
		}
		return $this;
	}

	public function getAction($key)
	{
		if (array_key_exists($key,$this->actions)) {
			return $this->actions[$key];
		}
	}

	public function _prepareActions()
	{
		return $this;
	}

	public function getButtons()
	{
		return $this->buttons;
	}

	public function setButtons(array $buttons)
	{
		$this->buttons = $buttons;
		return $this;
	}

	public function addButton($key,$value)
	{
		$this->buttons[$key] = $value;
		return $this;
	}

	public function removeButton($key)
	{
		if (array_key_exists($key,$this->buttons)) {
			unset($this->buttons[$key]);
		}
		return $this;
	}

	public function getButton($key)
	{
		if (array_key_exists($key,$this->buttons)) {
			return $this->buttons[$key];
		}
	}

	public function _prepareButtons()
	{
		return $this;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getTitle()
	{
		return $this->title;
	}
}