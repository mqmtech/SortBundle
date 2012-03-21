<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MQM\Bundle\SortBundle\Sort;
/**
 *
 * @author mqmtech
 */
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
    public function getMode();

    /**
     * @param string
     */
    public function setMode($mode);
        
    /**
     * @return SortInterface
     */
    public function switchMode();
    
}

?>
