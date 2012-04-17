<?php

namespace MQM\Bundle\SortBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SortExtension extends \Twig_Extension
{
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function getName()
    {
        return 'mqm_sort.twig_extension';
    }

    public function getFunctions()
    {
        return array();
    }
    
    public function getFilters()
    {
        return array();
    }
    
    public function getGlobals()
    {
        $sortManager = $this->container->get('mqm_sort.sort_manager');
        
        return array('mqm_sort_sort_manager' => $sortManager);
    }
}