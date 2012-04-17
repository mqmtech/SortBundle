<?php

namespace MQM\Bundle\SortBundle\Sort;

interface SortManagerInterface
{    
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
    public function getCurrentSort();
    
    /**
     * @param SortInterface
     */
    public function setCurrentSort(SortInterface $currentSort);
    
    /**
     * @return SortInterfaceManager
     */
    public function switchMode();

    /**
     * @param string $id
     * @param string $field
     * @param string $name
     * @param string $mode
     * @return SortManagerInterface
     */
    public function addSort($id, $field, $name, $mode = 'ASC');    
    
    /**
     * @return array
     */
    public function getSorts();
}
