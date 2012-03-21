<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MQM\Bundle\SortBundle\Sort;

use MQM\Bundle\SortBundle\Helper\HelperInterface;
use Symfony\Component\Routing\Router;
use MQM\ToolsBundle\Service\Utils;
/**
 * Description of Sort
 *
 * @author mqmtech
 */
class WebSort implements SortInterface{
    
    const DEF_ID = "NO_ID";
    const DEF_FIELD = "NO_FIELD";
    const DEF_MODE = "ASC";
    const DEF_NAME = "NO_NAME";
    
    /**
     *
     * @var string $id
     */
    private $id;

    /**
     *
     * @var string $field
     */
    private $field;
    
    /**
     *
     * @var string $mode
     */
    private $mode;    
    
    /**
     *
     * @var string $name
     */
    private $name;
    
    /**
     *
     * @var WebSortManger
     */
    private $sortManager;
    
    /**
     *
     * @var boolean $url 
     */
    private $isCurrent;
    
    /**
     *
     * @var HelperInterface $helper
     */
    private $helper;
    
    /**
     *
     * @var Router $router
     */
    private $router;
    
    /**
     *
     * @var string $responsePath
     */
    private $responsePath;
    
    /**
     *
     * @var array $responseParameters
     */
    private $responseParameters;
    
    /**
     *
     * @param HelperInterface $helper
     * @param Router $router
     * @param string $responsePath
     * @param array $responseParameters 
     */
    public function __construct(HelperInterface $helper, Router $router, string $responsePath=null, $responseParameters=null) {
        $this->setHelper($helper);
        $this->setRouter($router);
        $this->setResponsePath($responsePath);
        $this->setResponseParameters($responseParameters);
    }
    
    public function getResponsePath() {
        return $this->responsePath;
    }

    public function setResponsePath($responsePath) {
        $this->responsePath = $responsePath;
    }

    public function getResponseParameters() {
        return $this->responseParameters;
    }

    public function setResponseParameters($responseParameters) {
        $this->responseParameters = $responseParameters;
    }

        
    public function getHelper() {
        return $this->helper;
    }

    public function setHelper($helper) {
        $this->helper = $helper;
    }

    public function getRouter() {
        return $this->router;
    }

    public function setRouter($router) {
        $this->router = $router;
    }

        
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
    
    /**
     *
     * @return WebSortManager
     */
    public function getSortManager() {
        return $this->sortManager;
    }

    public function setSortManager($sortManager) {
        $this->sortManager = $sortManager;
    }

        
    public function getIsCurrent() {
        return $this->isCurrent;
    }

    public function setIsCurrent($isCurrent) {
        $this->isCurrent = $isCurrent;
    }    
        
    public function getField() {
        return $this->field;
    }

    public function setField($field) {
        $this->field = $field;
    }

    public function getMode() {
        return $this->mode;
    }

    public function setMode($mode) {
        $this->mode = $mode;
    }
    
    /**
     *
     * @return string
     */
    public function getURL() {
        
        $url = "";
        $parameters = $this->getResponseParameters();
        if ($parameters == null) {
            $parameters = $this->helper->getAllParametersFromRequestAndQuery();
        }
        $parameters[WebSortHelper::REQUEST_QUERY_PARAM] = WebSortHelper::generateModeId($this->getMode(), $this->getId());
       
        $path = $this->getResponsePath();
        if ($path == null) {
            $this->helper->getURI();
            $url = $path . $this->helper->toQueryString($parameters);
        }
        else {
            $url = $this->getRouter()->generate($path, $parameters);
        }
        
        return $url;
    }
        
    public function switchMode() {
        $currentMode = $this->getMode();
        if ($currentMode == WebSortHelper::VALUE_MODE_ASC) {
            $this->setMode(WebSortHelper::VALUE_MODE_DESC);
        }
        else {
            $this->setMode(WebSortHelper::VALUE_MODE_ASC);
        }
    }
    
    /**
     *
     * @return array
     */
    public function getValues(){
        return array($this->getField() => $this->getMode());
    }
}

?>
