<?php

namespace MQM\Bundle\SortBundle\Sort;

use MQM\Bundle\SortBundle\Helper\HelperInterface;
use Symfony\Component\Routing\Router;
use MQM\ToolsBundle\Service\Utils;

class WebSort implements SortInterface
{   
    private $id;
    private $field;
    private $mode;    
    private $name;
    private $isCurrent;
    private $url;    

    public function getUrl()
    {        
        return $this->url;
    }
    
    public function setUrl($url)
    {   
        $this->url = $url;
    }
    
    public function toArray()
    {
        return array($this->getField() => $this->getMode());
    }
        
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
        
    public function getIsCurrent()
    {
        return $this->isCurrent;
    }

    public function setIsCurrent($isCurrent)
    {
        $this->isCurrent = $isCurrent;
    }    
        
    public function getField()
    {
        return $this->field;
    }

    public function setField($field)
    {
        $this->field = $field;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
    }
}