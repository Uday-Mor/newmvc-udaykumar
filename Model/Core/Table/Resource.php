<?php 
/**
 * 
 */
class Model_Core_Table_Resource
{
	protected $adapter = null;

	public function setTableName($tableName)
	{
		$this->tableName = $tableName;
		return $this;
	}

	public function getTableName()
	{
		return $this->tableName;
	}

	public function setPrimaryKey($primaryKey)
	{
		$this->primaryKey = $primaryKey;
		return $this;
	}

	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	public function setAdapter(Model_Core_Adapter $adapter)
	{
		$this->adapter = $adapter;
		return $this;
	}

	public function getAdapter()
	{
		if ($this->adapter !== null) {
			return $this->adapter;
		}
		$adapter = new Model_Core_Adapter();
		$this->setAdapter($adapter);
		return $adapter;
	}

	public function fetchRow($query)
	{
		$adapter = $this->getAdapter();
		$result = $adapter->fetchRow($query);
		return $result;	
	}

	public function fetchAll($query)
	{
		$adapter = $this->getAdapter();
		$results = $adapter->fetchAll($query);
		return $results;
	}

	public function load($id,$column = null)
	{
		$adapter = $this->getAdapter();
		if (!$column) {
			$column = $this->getPrimaryKey(); 
		}
		$query = 'SELECT * FROM `'.$this->getTableName().'` WHERE `'.$column.'` = "'.$id.'"';
		$result = $adapter->fetchRow($query);
		return $result;
	}

	public function insert(array $data)
	{
		$columns = "`" . implode("`, `", array_keys($data)) . "`";
		$values = "'" . implode("', '", array_values($data)) . "'";
		$query = 'INSERT INTO `'.$this->getTableName().'` ('.$columns.') VALUES ('.$values.')';
		$adapter = $this->getAdapter();
		$insertId = $adapter->insert($query);
		return $insertId;
	}

	public function update($data,$condition)
	{
		$set = "";
		foreach ($data as $column => $value) {
		  $set .= '`'.$column.'` = "'.$value.'",';
		}
		
		$set = rtrim($set, ", ");
		$where = "";
		if (is_array($condition)) {
			foreach ($condition as $column => $value) {
				$where .= '`'.$column.'` = "'.$value.'" AND ' ;
			}
		}else{
			$where = '`'.$this->getPrimaryKey().'` = "'.$condition.'"'; 
		}

		$where = rtrim($where, " AND ");
		$query = 'UPDATE `'.$this->getTableName().'` SET '.$set.' WHERE '.$where;
		$adapter = $this->getAdapter();
		$result = $adapter->update($query);
		return $result;
	}

	public function delete($condition)
	{
		$where = "";
		if (is_array($condition)) {
			foreach ($condition as $column => $value) {
				$where .= '`'.$column.'` = "'.$value.'" AND ' ;
			}
		}else{
			$where = '`'.$this->getPrimaryKey().'` = "'.$condition.'"'; 
		}

		$where = rtrim($where, " AND ");
		$query = 'DELETE FROM `'.$this->getTableName().'` WHERE '.$where;
		$adapter = $this->getAdapter();
		$result = $adapter->delete($query);
		return $result;
	}
}
?>