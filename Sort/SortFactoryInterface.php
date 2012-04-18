<?php

namespace MQM\SortBundle\Sort;

interface SortFactoryInterface {
   
    /**
     * @return SortInterface
     */
    public function createSort();    
    
    /**
     * @param string $responsePath|null
     * @param array $responseParameters|null
     * 
     * @return SortManagerInterface
     */
    public function createSortManager(string $responsePath = null, array $responseParameters = null);
}