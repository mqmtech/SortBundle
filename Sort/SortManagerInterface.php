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
interface SortManagerInterface {
    
    /**
     * @return string
     */
    public function getMode();

    /**
     * @param string
     */
    public function setMode($mode);
    
    /**
     *
     * @return SortInterface
     */
    public function getCurrentSort();
    
    /**
     * @param SortInterface
     */
    public function setCurrentSort(SortInterface $currentSort);
    
    /**
     *
     * @return SortInterfaceManager
     */
    public function switchMode();

    /**
     * Add a sort item to the SortManager
     * 
     * @param string $id
     * @param string $field
     * @param string $name
     * @param string $mode
     * @param string $responsePath
     * @return SortManagerInterface
     */
    public function add($id, $field, $name, $mode = 'ASC', $responsePath = null);
    
    
    /**
     * @return array of SortInterfaceManager
     */
    public function getSorts();
    
}

?>
