<?php
/**
 * 
 */
class Model_Category extends Model_Core_Table
{
	public $resourceClass = 'Category_Resource';
    public $collectionClass = 'Category_Collection';

    public function getStatusText()
    {
        $statues = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status,$statues)) {
            return $statues[$this->status];
        }
        return $statues[Model_Category_Resource::STATUS_DEFAULT];
    }

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }
        return Model_Category_Resource::STATUS_DEFAULT;
    }

    public function getPathName()
    {
        $query = 'SELECT `category_id` , `name` FROM `category`';
        $categories = Ccc::getModel('Core_Adapter')->fetchPairs($query);
        $path = '';
        foreach (explode('->',$this->path) as $id) {
            if (array_key_exists($id,$categories)) {
                $path .= $categories[$id].'=>';
            }
        }
        return rtrim($path,'=>');
    }

    public function getParentCategories()
    {
        $query = 'SELECT `category_id` , `name` FROM `category`';
        $categories = Ccc::getModel('Core_Adapter')->fetchPairs($query);
        $path = '29->';
        if ($this->category_id) {
            $path = $this->path;
            $query = "SELECT `category_id`,`path` FROM `category` WHERE `path` NOT LIKE '{$path}%' ";
        }else{
            $query = "SELECT `category_id`,`path` FROM `category` WHERE `path` LIKE '{$path}%' ";
        }

        $parentCategories = Ccc::getModel('Core_Adapter')->fetchPairs($query);
        foreach ($parentCategories as $categoryId => &$pathName) {
            $path = '';
            foreach (explode('->',$pathName) as $id) {
                if (array_key_exists($id,$categories)) {
                    $path .= $categories[$id].'=>';
                }
            }
            $pathName = $path;
        }
        
        return $parentCategories;
    }

    public function updatePath()
    {
        if (!$this->getId()) {
            return false;
        }

        $oldPath = $this->path;
        $parent = Ccc::getModel('Category')->load($this->parent_id);
        if(!$parent){
            $this->path = $this->getId().'->';
        }else{
            $this->path = $parent->path.$this->getId().'->';
        }

        $this->save();
        $query = "UPDATE `category` SET `path` = REPLACE(`path`,'{$oldPath}','{$this->path}') WHERE `path` LIKE '{$oldPath}%' ORDER BY `path` ASC";
        if (!($result = Ccc::getModel('Core_Adapter')->update($query))) {
            $this->getMessage()->addMessage('Path is not Updated!!!');
        }

        return $this;
    }
}