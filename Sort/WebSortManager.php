<?php

namespace MQM\Bundle\SortBundle\Sort;

use MQM\Bundle\SortBundle\Helper\HelperInterface;
use MQM\Bundle\SortBundle\Sort\SortFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Locale\Exception\NotImplementedException;

class WebSortManager implements SortManagerInterface
{    
    const REQUEST_SORT_MODE_PARAM_NAME = 'sort';
    const ASC = 'ASC';
    const ASC_SYMBOL = '+';
    const DESC = 'DESC';
    const DESC_SYMBOL = '-';
    
    private $helper;
    private $sortFactory;
    private $router;
    private $responsePath;
    private $responseParameters;
    private $currentSort;
    private $sorts = array();

    public function __construct(HelperInterface $helper, SortFactoryInterface $sortFactory, RouterInterface $router, $responsePath = null, array $responseParameters = null) 
    {
        $this->helper = $helper;
        $this->sortFactory = $sortFactory;
        $this->router = $router;
        $this->responsePath = $responsePath;
        $this->responseParameters = $responseParameters;
    }
    
    public function addSort($id, $field, $name, $mode = self::ASC)
    {
        if ($this->sortFactory == null) {
            throw new NotImplementedException('Missing SortFactory dependency in WebSortManager instance');
        }
        $sort = $this->sortFactory->createSort();        
        $sort->setId($id); 
        $sort->setField($field);
        $sort->setName($name);
        $sort->setMode($mode);        
        $this->sorts[$sort->getId()] = $sort;
        
        $current = $this->getCurrentSort();
        if ($current == null) {
            $this->setCurrentSort($sort);
        }
        
        return $this;
    }
    
    public function init()
    {
        $this->determineCurrentSortMode();
        $this->generateAndSetUrls();
        
        return $this;
    }
    
    private function determineCurrentSortMode()
    {
        $query = $this->helper->getParametersByRequestMethod();
        $modeId = $query->get(self::REQUEST_SORT_MODE_PARAM_NAME);
        $id = $this->getIdFromRequestParam($modeId);
        $mode = $this->getModeFromRequestParam($modeId);
        if ($id != null) {
            if (isset($this->sorts[$id])) {
                $sort = $this->sorts[$id];
                $sort->setMode($mode);
                $this->setCurrentSort($sort);
            }
        }
    }
    
    private function getIdFromRequestParam($str)
    {
        if ($str == null) {
            return null;
        }
        $mode = substr($str, 0, 1);
        if ($mode == self::DESC_SYMBOL || $mode == self::ASC_SYMBOL) {
            $length = strlen($str);
            return substr($str, 1, $length - 1);
        }
        
        return $str;
    }
    
    private function getModeFromRequestParam($str)
    {
        if ($str == null) {
            return null;
        }
        $mode = substr($str, 0, 1);
        if ($mode == self::DESC_SYMBOL) {
            return self::DESC;
        }
        else
            return self::ASC;
    }
    
    private function generateAndSetUrls()
    {
        foreach ($this->sorts as $sort) {
            $this->generateAndSetUrlToSort($sort);
        }
    }
    
    private function generateAndSetUrlToSort($sort)
    {
        $url = 'no_url';
        $parameters = $this->responseParameters;
        if ($parameters == null) {
            $parameters = $this->helper->getAllParametersFromRequestAndQuery();
        }
        $parameters[self::REQUEST_SORT_MODE_PARAM_NAME] = $this->generateRequestParam($sort->getMode(), $sort->getId());
        $path = $this->responsePath;
        if ($path == null) {
            $this->helper->getUri();
            $url = $path . $this->helper->toQueryString($parameters);
        }
        else {
            $url = $this->router->generate($path, $parameters);
        }        
        $sort->setUrl($url);
    }

    private function generateRequestParam($mode, $id)
    {
        $modeid = '';
        if ($mode != null) {
            if ($mode == self::DESC) {
                $modeid = self::DESC_SYMBOL;
            }
        }
        if ($id != null) {
            $modeid .= $id;
        }
        
        return $modeid;
    }
    
    public function switchMode()
    {        
        $currentSort = $this->getCurrentSort();
        $currentMode = $this->getMode();
        if ($currentMode == self::ASC) {
            $currentSort->setMode(self::DESC);
        }
        else {
            $currentSort->setMode(self::ASC);
        }
        $this->generateAndSetUrlToSort($currentSort);

        return $this;
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
    
    public function getSorts()
    {
        return $this->sorts;
    }
    
    public function getCurrentSort()
    {
        return $this->currentSort;
    }
    
    public function setCurrentSort(SortInterface $currentSort)
    {
        $this->currentSort = $currentSort;
        $this->currentSort->setIsCurrent(true);
    }
}
