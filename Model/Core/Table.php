<?php 
/**
 * 
 */
class Model_Core_Table
{
	protected $data = [];
	protected $resourceClass = 'Core_Table_Resource';
	protected $collectionClass = 'Core_Table_Collection';
	protected $resource = null;
	protected $collection = null;

	public function __set($key,$value)
	{
		$this->data[$key] = $value; 
	}

	public function __get($key)
	{
		if (array_key_exists($key,$this->data)) {
			return $this->data[$key];
		}
		return null;
	}

	public function __unset($key)
	{
		if (array_key_exists($key,$this->data)) {
			unset($this->data[$key]);
		}
	}

	public function setId($id)
	{
		$this->data[$this->getResource()->getPrimaryKey()] = $id;
 	}

	public function getId()
	{
		if (array_key_exists($this->getResource()->getPrimaryKey(),$this->data)) {
			return $this->data[$this->getResource()->getPrimaryKey()];
		}
		return false;
	}

	public function setResource($resource)
	{
		$this->resource = $resource;
		return $this;
	}

	public function getResource()
	{
		if ($this->resource) {
			return $this->resource;
		}
		$resource = Ccc::getModel($this->resourceClass);
		$this->setResource($resource);
		return $resource;
	}

	public function setCollection($collection)
	{
		$this->collection = $collection;
		return $this;
	}

	public function getCollection()
	{
		if ($this->collection) {
			return $this->collection;
		}
		$collection = Ccc::getModel($this->collectionClass);
		$this->setCollection($collection);
		return $collection;
	}

	public function addData($key,$value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function setData(array $data)
	{
		$this->data = array_merge($this->data,$data);
		return $this;
	}

	public function getData($key = null)
	{
		if ($key == null) {
			return $this->data;
		}
		if (array_key_exists($key,$this->data)) {
			return $this->data[$key];
		}
		return null;
	}

	public function removeData($key = null)
	{
		if (!$key) {
			$this->data = [];
		}
		if (array_key_exists($key,$this->data)) {
			unset($this->data[$key]);
		}
		return $this;
	}

	public function fetchAll($query)
	{
		$data = $this->getResource()->fetchAll($query);
		if (!$data) {
			return false;
		}
		foreach ($data as &$item) {
			$item = (new $this)->setData($item)->setResource($this->getResource())->setCollection($this->getCollection());
		}
		$collection = $this->getCollection()->setData($data);
		return $collection;
	}

	public function fetchRow($query)
	{
		$data = $this->getResource()->fetchRow($query);
		if (!$data) {
			return false;
		}
		$data = $this->setData($data);
		return $this;
	}

	public function load($id,$column=null)
	{
		$data = $this->getResource()->load($id,$column);
		if (!$data) {
			return false;
		}
		$data = $this->setData($data);
		return $this;
	}

	public function save($condition = null)
	{
		if (array_key_exists($this->getResource()->getPrimaryKey(),$this->getData())) {
			if (!$condition) {
				$condition = $this->getData($this->getResource()->getPrimaryKey());	
			}
			$result = $this->getResource()->update($this->getData(),$condition);
			return $result;
		}
		$insertId = $this->getResource()->insert($this->getData());
		return $insertId;
	}

	public function delete()
	{
		if (array_key_exists($this->getResource()->getPrimaryKey(),$this->getData())) {
			$result = $this->getResource()->delete($this->getData($this->getResource()->getPrimaryKey()));
			return $result;
		}
	}
}
?>