<?php

namespace MQM\SortBundle\Sort;

use MQM\SortBundle\Helper\HelperInterface;
use Symfony\Component\Routing\RouterInterface;



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