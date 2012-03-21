<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MQM\Bundle\SortBundle\Sort;

use MQM\Bundle\SortBundle\Helper\HelperInterface;
use Symfony\Component\Routing\RouterInterface;
use MQM\Bundle\SortBundle\Sort\SortInterface;
use MQM\Bundle\SortBundle\Sort\SortManagerInterface;
/**
 * Description of WebPageFactory
 *
 * @author mqmtech
 */
class WebSortFactory implements SortFactoryInterface{

    /*
     * var HelperInterface $helper
     */
    private $helper;
    
    /**
     * var RouterInterface $router
     */
    private $router;
    
    /**
     *
     * @param HelperInterface $helper
     * @param Router $router 
     */
    public function __construct(HelperInterface $helper, RouterInterface $router) {
        $this->setHelper($helper);
        $this->setRouter($router);
    }
    
    /**
     *
     * @return SortInterface
     */
    public function buildSort() {
        $sort = new WebSort($this->getHelper(), $this->getRouter());
        return $sort;
    }
    
    /**
     *
     * @param string $responsePath|null
     * @param array $responseParameters|null
     * @return SortManagerInterface
     */
    public function buildSortManager(string $responsePath = null, array $responseParameters = null) {

        $sortManager = new WebSortManager($this->getHelper(), $this, $responsePath, $responseParameters);
        $sortManager->setSortFactory($this);
        
        return $sortManager;
    }
    
    /**
     *
     * @return RouterInterface
     */
    public function getRouter() {
        return $this->router;
    }

    /**
     *
     * @param RouterInterface $router 
     */
    public function setRouter($router) {
        $this->router = $router;
    }
    
    public function getHelper() {
        return $this->helper;
    }

    public function setHelper($helper) {
        $this->helper = $helper;
    }
}

?>
