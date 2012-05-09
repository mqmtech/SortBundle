<?php

namespace MQM\SortBundle\Sort;

use MQM\SortBundle\Sort\SortInterface;

class WebSort implements SortInterface
{
    private $id;
    private $field = array();
    private $mode;
    private $name;
    private $url;
    private $options;
    
    public function __construct()
    {
        $this->init();
    }
    
    protected function init()
    {
        $this->field = $this->getDefaultFieldOptions();
    }

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
        
    public function getField($entityAlias = '')
    {
        if (isset($this->field['ignoreEntityAlias']) && $this->field['ignoreEntityAlias']) {
            return $this->field['name'];
        }
        $entityAlias = $entityAlias == '' ?: $entityAlias . '.';

        return $entityAlias . $this->field['name'];
    }

    public function setField($field)
    {
        if (is_array($field)) {
            $this->field = $field;
        }
        else if (is_string($field)){
            $this->field['name'] = $field;
        }
        else {
            throw new \Exception('NotValid variable type of field, must be string or array');
        }
    }
    
    protected function getDefaultFieldOptions()
    {
        return array(
            'ignoreEntityAlias' => false,
            'name'           => '',
        );
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