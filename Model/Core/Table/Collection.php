<?php
/**
 * 
 */
class Model_Core_Table_Collection
{
	public $data = [];

	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	public function getData()
	{
		return $this->data;
	}

	public function getCount()
	{
		return count($this->data);
	}

	public function getFirst()
	{
		if ($this->data[0]) {
			return $this->data[0];
		}
	}

	public function getLast()
	{
		if ($this->getCount() > 0) {
			return $this->data[$this->getCount() - 1];
		}
	}
}