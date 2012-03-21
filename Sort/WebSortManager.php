<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MQM\Bundle\SortBundle\Sort;

use MQM\Bundle\SortBundle\Helper\HelperInterface;

/**
 * Description of WebSortManager
 *
 * @author mqmtech
 */
class WebSortManager implements SortManagerInterface{

    /**
     *
     * @var array
     */
    private $responsePath;
    
    /**
     *
     * @var array
     */
    private $responseParameters;
    
    /**
     *
     * @var SortInterface
     */
    private $currentSort;
    
    /**
     *
     * @var array
     */
    private $sorts;
    
    /**
     *
     * @var HelperInterface
     */
    private $helper;
    
    /**
     *
     * @var SortFactoryInterface
     */
    private $sortFactory;


    public function __construct(HelperInterface $helper, SortFactoryInterface $sortFactory, $responsePath=null, array $responseParameters=null) 
    {
        $this->setHelper($helper);
        $this->setSortFactory($sortFactory);
        $this->setResponsePath($responsePath);
        $this->setResponseParameters($responseParameters);
    }
    
    public function initialize($default = null)
    {
        $responseParameters = $this->getResponseParameters();
        
        if ($responseParameters == null) {
            $responseParameters = $this->helper->getAllParametersFromRequestAndQuery();
        }
        
        $this->setResponseParameters($responseParameters);
        $query = $this->helper->getParametersByRequestMethod();
        $modeId = $query->get(WebSortHelper::REQUEST_QUERY_PARAM);
        $id = WebSortHelper::getIdFromModeId($modeId);
        $mode = WebSortHelper::getModeFromModeId($modeId);
        
        if ($default != null) {
            if ($field == null) {
                if (array_key_exists(0, $default)) {
                $field = $default[0];    
                }                
            }
            if ($mode == null) {
                if (array_key_exists(1, $default)) {
                    $mode = $default[1];
                }
            }
        }

        //Set actual sort as current
        if ($id!=null) {
            if (isset ($this->sorts[$id])) {
                $sort = $this->sorts[$id];
                $sort->setMode($mode);
                $this->setCurrentSort($sort);
            }
        }
        //Set actual sort as current
    }
    
    /**
     *
     * @return SortInterfaceManager
     */
    public function switchMode() 
    {
        
        $currentSort = $this->getCurrentSort();
        $currentSort->switchMode();

        return $this;
    }
    
    public function getValues(){
        $currentSort = $this->getCurrentSort();
        
        return $currentSort->getValues();
    }
    
    /**
     *
     * @param string $id
     * @param string $field
     * @param string $name
     * @param string $mode
     * @param string $responsePath
     * @return \MQM\Bundle\SortBundle\Sort\WebSortManager 
     */
    public function add($id, $field, $name, $mode = 'ASC', $responsePath = null)
    {
        $sortFactory = $this->getSortFactory();
        if ($sortFactory == null){
            throw new \ErrorException('Missing SortFactory dependency in WebSortManager instance');
        }
        $sort = $sortFactory->buildSort();
        
        $sort->setId($id); 
        $sort->setField($field);
        $sort->setName($name);
        $sort->setMode($mode);
        
        if ($responsePath == null) {
            $responsePath = $this->getResponsePath();
        }
        
        $sort->setResponsePath($responsePath);        
        $sort->setResponseParameters($this->getResponseParameters());
        
        $this->addSort($sort);
        
        return $this;
    }
  
    /**
     *
     * @param WebSort $sort
     * @return WebSortManager 
     */
    public function addSort(WebSort $sort)
    {

        if($sort == null){
            throw new \Exception ("Custom Exception: sort is null in addSort function");
        }
        
        $sort->setSortManager($this);
        
        $isCurrent = false;
        if ($this->sorts == null) {
            $this->sorts = array();
            $isCurrent = true;
        }
        
        $this->sorts[$sort->getId()]=$sort;
        
        if ($isCurrent== true) {
            $this->setCurrentSort($sort);
        }
        
        return $this;
    }
    
    public function getResponsePath() 
    {
        return $this->responsePath;
    }

    public function setResponsePath($responsePath) 
    {
        $this->responsePath = $responsePath;
    }

    public function getResponseParameters() 
    {
        return $this->responseParameters;
    }

    public function setResponseParameters($responseParameters) 
    {
        $this->responseParameters = $responseParameters;
    }

    /**
     *
     * @return string
     */
    public function getField() 
    {
        $current = $this->getCurrentSort();
        return $current->getField();
    }

    public function setField($field) 
    {
        $current = $this->getCurrentSort();
        $current->setField($field);
    }

    public function getMode() 
    {
        $current = $this->getCurrentSort();
        return $current->getMode();
    }

    public function setMode($mode) 
    {
        $current = $this->getCurrentSort();
        $current->setMode($mode);
    }
    
    /**
     *
     * @return Sort
     */
    public function getCurrentSort()
    {
        return $this->currentSort;
    }
    
    /**
     *
     * @param WebSort $currentSort 
     */
    public function setCurrentSort(SortInterface $currentSort)
    {
        //Reset currents
        if ($this->getSorts() != null) {
            
            foreach ($this->sorts as $key => $cSort) {
                $cSort->setIsCurrent(false);
            }
            //End Reset Currents
            $this->currentSort = $currentSort;
            $this->currentSort->setIsCurrent(true);
        }
        
    }
    
    public function getSorts()
    {
        return $this->sorts;
    }
    
    public function getSortFactory() 
    {
        return $this->sortFactory;
    }

    public function setSortFactory($sortFactory) 
    {
        $this->sortFactory = $sortFactory;
    }
    
    public function getHelper() 
    {
        return $this->helper;
    }

    public function setHelper($helper) 
    {
        $this->helper = $helper;
    }

}

?>
