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
interface SortFactoryInterface {
   
    /**
     * @return SortInterface
     */
    public function buildSort();    
    
    /**
     *
     * @param string $responsePath|null
     * @param array $responseParameters|null
     * @return SortManagerInterface
     */
    public function buildSortManager(string $responsePath = null, array $responseParameters = null);
}

?>
