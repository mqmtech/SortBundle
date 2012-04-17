<?php

namespace MQM\Bundle\SortBundle\Sort;

use MQM\Bundle\SortBundle\Helper\HelperInterface;
use Symfony\Component\Routing\RouterInterface;
use MQM\Bundle\SortBundle\Sort\SortInterface;
use MQM\Bundle\SortBundle\Sort\SortManagerInterface;

class WebSortFactory implements SortFactoryInterface
{
    private $helper;
    private $router;
    
    /**
     * {@inheritDoc}
     */
    public function __construct(HelperInterface $helper, RouterInterface $router)
    {
        $this->helper = $helper;
        $this->router = $router;
    }    
        
    /**
     * {@inheritDoc}
     */
    public function createSortManager(string $responsePath = null, array $responseParameters = null)
    {
        $sortManager = new WebSortManager($this->helper, $this, $this->router, $responsePath, $responseParameters);
        
        return $sortManager;
    }
    
    /**
     * {@inheritDoc}
     */
    public function createSort()
    {
        $sort = new WebSort();
        
        return $sort;
    }
}