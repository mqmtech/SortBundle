<?php

namespace MQM\SortBundle\Sort;

interface SortManagerInterface
{    
    const ASC = 'ASC';
    const DESC = 'DESC';
    
    /**
     * @return SortManagerInterface 
     */
    public function init(array $sorts = null);
    
    /**
     * @param query
     * @return query 
     */
    public function sortQuery($query);
    
    /**
     * @return SortInterfaceManager
     */
    public function switchMode();

    /**
     * @param string $id
     * @param string $field
     * @param string $name
     * @param string $mode
     * 
     * @return SortManagerInterface
     */
    public function addSort($id, $field, $name, $mode = self::ASC, array $options = array()); 
    
    /**
     * @return SortInterface
     */
    public function getCurrentSort();
    
    /**
     * @param SortInterface|string sort id
     */
    public function setCurrentSort($currentSort);
    
    /**
     * @return array
     */
    public function getSorts();
}
