<?php

namespace MQM\SortBundle\Sort;

use MQM\SortBundle\Helper\HelperInterface;
use MQM\SortBundle\Sort\SortFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Locale\Exception\NotImplementedException;


class WebSortManager implements SortManagerInterface
{    
    const REQUEST_SORT_MODE_PARAM_NAME = 'sort';
    const ASC_SYMBOL = '+';
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
    
    public function sortQuery($query) {
        throw new NotImplementedException('sortQuery method is not implemented by WebSortManager, use QuerySortManager class instead');
    }
    
    public function init(array $sorts = null)
    {
        $this->determineCurrentSort();
        $this->assignUrlPerSort();
        
        return $this;
    }
    
    public function addSort($id, $field, $name, $mode = self::ASC, array $options = array())
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
        if (isset($options['default']) && $options['default']) {
            $this->setCurrentSort($sort);
        }        
        
        return $this;
    }
    
    private function determineCurrentSort()
    {
        $this->determineCurrentSortFromUrl();
        if ($this->getCurrentSort() == null) {
            $this->determineCurrentSortByDefault();
        }
    }
    
    private function determineCurrentSortFromUrl()
    {
        $query = $this->helper->getParametersByRequestMethod();
        $requestParam = $query->get(self::REQUEST_SORT_MODE_PARAM_NAME);
        if ($requestParam != null) {
            $id = $this->getIdFromRequestParam($requestParam);
            $mode = $this->getModeFromRequestParam($requestParam);        
            if (isset($this->sorts[$id])) {
                $sort = $this->sorts[$id];
                $sort->setMode($mode);
                $this->setCurrentSort($sort);
            }
        }
    }
    
    private function determineCurrentSortByDefault()
    {
        $firtElement = current($this->sorts);
        if ($firtElement == false) {
            return;
        }
        $this->setCurrentSort($firtElement);
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
    
    private function assignUrlPerSort()
    {
        foreach ($this->sorts as $sort) {
            $this->assignUrlToSort($sort);
        }
    }
    
    private function assignUrlToSort($sort)
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
        $currentMode = $currentSort->getMode();
        if ($currentMode == self::ASC) {
            $currentSort->setMode(self::DESC);
        }
        else {
            $currentSort->setMode(self::ASC);
        }
        $this->assignUrlToSort($currentSort);

        return $this;
    }
    
    public function getSorts()
    {
        return $this->sorts;
    }    
    
    public function getCurrentSort()
    {
        return $this->currentSort;
    }
    
    public function setCurrentSort($currentSort)
    {
        if (is_a($currentSort, 'MQM\SortBundle\Sort\SortInterface')) {
            $this->currentSort = $currentSort;
        }
        else if (is_string($currentSort)) {
            $sort = $this->sorts[$currentSort];
            if ($sort != null) {
                $this->currentSort = $sort;
            }            
        }
        
        return $this;
    }
}
