<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\FrameworkBundle\Test\Sort;

use MQM\Bundle\SortBundle\Sort\WebSortFactory;
use MQM\Bundle\SortBundle\Sort\WebSortManager;

class SortManagerTest extends \PHPUnit_Framework_TestCase
{   
    public function testMockObject()
    {
        $spec = $this->getMockBuilder('\Symfony\Component\HttpFoundation\Request');
        $mock = $spec->getMock();
        $this->assertTrue($mock instanceof \Symfony\Component\HttpFoundation\Request);
    }
    
    public function testHelperMockObject()
    {
        $helperMock = $this->mockHelper();
        
        $this->assertTrue($helperMock instanceof \MQM\Bundle\SortBundle\Helper\Helper);
        $this->assertEquals($helperMock->getURI(), '/path/mock');
        $this->assertEquals($helperMock->toQueryString(array('a' => 'b')), '?query=value_mock');
        
    }
    
    public function testWebSortManager()
    {
        $webSortManager = $this->getWebSortManager();
        $this->assertNotNull($webSortManager);
        
        $webSortManager->add('id_a', 'field_a', 'name_a')
                       ->add('id_b', 'field_b', 'name_b');
        
        $webSortManager->initialize();
        
        $sort = $webSortManager->getCurrentSort();
        $this->assertEquals('id_a', $sort->getId());        
    }
    
    public function getWebSortManager()
    {
        $helper = $this->mockHelper();
        $router = $this->mockRouter();

        $sortFactory = new WebSortFactory($helper, $router);
        
        $webSortManager = new WebSortManager($helper, $sortFactory);
        
        
        return $webSortManager;
    }
    
    //Helper functions
    
    public function mockHelper()
    {
        // Mock object
        $spec = $this->getMockBuilder('\MQM\Bundle\SortBundle\Helper\Helper')
                ->disableOriginalConstructor();
        $helperMock = $spec->getMock();
                
        // Mock methods
        $helperMock->expects($this->any())
                    ->method('getURI')
                    ->will($this->returnValue('/path/mock'));
        
        $helperMock->expects($this->any())
                    ->method('toQueryString')
                    ->will($this->returnValue('?query=value_mock'));
        
        $helperMock->expects($this->any())
                    ->method('getParametersByRequestMethod')
                    ->will($this->returnValue(new \Symfony\Component\HttpFoundation\ParameterBag()));
        
        return $helperMock;
    }
    
    public function mockRouter()
    {
        
         $spec = $this->getMockBuilder('\Symfony\Bundle\FrameworkBundle\Routing\Router')
                ->disableOriginalConstructor();
        $mock = $spec->getMock();

        return $mock;
        
    }
}
