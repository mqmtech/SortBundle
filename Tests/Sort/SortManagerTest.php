<?php
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
        $this->assertEquals($helperMock->getUri(), '/path/mock');
        $this->assertEquals($helperMock->toQueryString(array('a' => 'b')), '?query=value_mock');        
    }
    
    public function testWebSortManager()
    {
        $webSortManager = $this->getWebSortManager();
        $this->assertNotNull($webSortManager);
        
        $webSortManager->addSort('id_a', 'field_a', 'name_a')
                       ->addSort('id_b', 'field_b', 'name_b');
        
        $webSortManager->init();
        
        $sort = $webSortManager->getCurrentSort();
        $this->assertEquals('id_a', $sort->getId());        
    }
    
    public function getWebSortManager()
    {
        $helper = $this->mockHelper();
        $router = $this->mockRouter();

        $sortFactory = new WebSortFactory($helper, $router);        
        $webSortManager = new WebSortManager($helper, $sortFactory, $router);        
        
        return $webSortManager;
    }
    
    public function mockHelper()
    {
        // Mock object
        $spec = $this->getMockBuilder('\MQM\Bundle\SortBundle\Helper\Helper')
                ->disableOriginalConstructor();
        $helperMock = $spec->getMock();
                
        // Mock methods
        $helperMock->expects($this->any())
                    ->method('getUri')
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
