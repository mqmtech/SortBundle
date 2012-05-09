<?php

namespace MQM\SortBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use MQM\SortBundle\Sort\SortManagerInterface;

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
        return array(
            'mqm_sort_render_choice' => new \Twig_Function_Method($this, 'renderSortChoice', array(
                'is_safe' => array('html') // this enables raw-html output
            )),
        );
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

    public function renderSortChoice($view = null, SortManagerInterface $sortManager = null, array $parameters = array())
    {
        $sortManager = $sortManager != null ? $sortManager : $this->container->get('mqm_sort.sort_manager');
        $view = $view == null ? 'MQMSortBundle:Sort:sort_choice.partialhtml.twig' : $view;
        $parameters['sortManager'] = $sortManager;

        $content = $this->container->get('templating')->render($view, $parameters);
        return $content;
    }
}