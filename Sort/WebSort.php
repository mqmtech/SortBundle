<?php

namespace MQM\SortBundle\Sort;

use MQM\SortBundle\Sort\SortInterface;

class WebSort implements SortInterface
{
    private $id;
    private $field;
    private $mode;
    private $name;
    private $url;
    private $options;

    public function getUrl()
    {        
        return $this->url;
    }
    
    public function setUrl($url)
    {   
        $this->url = $url;
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
    
    public function getOptions()
    {
        return $this->options;
    }
    
    public function setOptions($options)
    {
        $this->options = $options;
    }
}