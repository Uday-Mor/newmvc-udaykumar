<?php
/**
 * 
 */
class Model_Product_Media_Resource extends Model_Core_Table_Resource
{
    public $tableName = 'product_media';
    public $primaryKey = 'image_id';

    //update method
    public function update($data,$condition)
    {
        unset($data['image_id']);
        $set = "";
        foreach ($data as $column => $value) {
          $set .= '`'.$column.'` = "'.$value.'",';
        }
        
        $set = rtrim($set, ", ");
        $where = "";
        if (is_array($condition)) {
            if (!array_key_exists('product_id',$condition)) {
                $ids = join(',',$condition);
                $where = '`'.$this->primaryKey.'` IN ('.$ids.')';   
            }else{
                foreach ($condition as $column => $value) {
                    $where .= '`'.$column.'` = "'.$value.'" AND ' ;
                }
            }
        }else{
            $where = '`'.$this->primaryKey.'` = "'.$condition.'"'; 
        }

        $where = rtrim($where, " AND ");
        $query = 'UPDATE `'.$this->tableName.'` SET '.$set.' WHERE '.$where;
        $adapter = $this->getAdapter();
        $result = $adapter->update($query);
        return $result;
    }
}
?>