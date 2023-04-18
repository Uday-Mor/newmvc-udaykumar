<?php
/**
 * 
 */
class Block_Eav_Attribute_Inputtype_Text extends Block_Core_Templates
{
    protected $attribute = null;
    protected $row = null;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('eav/attribute/inputtype/text.phtml');
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    public function getRow()
    {
        return $this->row;
    }

    public function setRow($row)
    {
        $this->row = $row;
        return $this;
    }
}