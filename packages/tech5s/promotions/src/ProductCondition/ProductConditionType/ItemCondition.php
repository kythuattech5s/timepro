<?php
namespace Tech5s\Promotion\ProductCondition\ProductConditionType;
class ItemCondition
{
    protected $name;
    protected $type;
    protected $mapId;
    public function __construct($name,$type,$mapId = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->mapId = $mapId;
    }
    public function buildStrId()
    {
        return trim($this->type.'_'.$this->mapId,'_');
    }
    public function getName()
    {
        return $this->name;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getMapId()
    {
        return $this->mapId;
    }
}