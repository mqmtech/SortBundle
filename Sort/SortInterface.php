<?php

namespace MQM\Bundle\SortBundle\Sort;

interface SortInterface {

    /**
     * @return int
     */
    public function getId();
    
    /**
     * @param int
     */
    public function setId($id);
    
    /**
     * @return array 
     */
    public function toArray();
    
    /**
     * @return string
     */
    public function getName();
    
    /**
     * @param string
     */
    public function setName($name);            
        
    /**
     * @return bool
     */
    public function getIsCurrent();

    /**
     * @param bool
     */
    public function setIsCurrent($isCurrent);
    
    /**
     * @return string 
     */
    public function getField();

    /**
     * @param string 
     */
    public function setField($field);

    /**
     * @return string
     */
    public function getMode();

    /**
     * @param string
     */
    public function setMode($mode);
}
