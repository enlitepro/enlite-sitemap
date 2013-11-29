<?php

namespace EnliteSitemapTest\Service;

use EnliteSitemap\Service\SitemapService;
use EnliteSitemap\Entity\Sitemap;
use EnliteSitemap\Repository\SitemapRepository;
use Zend\ServiceManager\ServiceManager;
use Doctrine\ORM\EntityManager;

class SitemapServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testLoadById()
    {
        $id = 123;
        $entity = new Sitemap();
        
        $object = $this->getObject();
        $object->getSitemapRepository()->expects($this->once())->method('find')
            ->with($id)->will($this->returnValue($entity));
        
        $this->assertSame($entity, $object->loadById($id));
    }

    /**
     * @expectedException \EnliteSitemap\Exception\NotFoundException
     */
    public function testLoadByIdFailed()
    {
        $id = 123;
        
        $object = $this->getObject();
        $object->getSitemapRepository()->expects($this->once())->method('find')
            ->with($id)->will($this->returnValue(false));
        
        $object->loadById($id);
    }

    public function testSearch()
    {
        $criteria = ['id' => 123];
        $result = [new Sitemap()];
        
        $object = $this->getObject();
        $object->getSitemapRepository()->expects($this->once())->method('findBy')
            ->with($criteria)->will($this->returnValue($result));
        
        $this->assertSame($result, $object->search($criteria));
    }

    public function testSave()
    {
        $entity = new Sitemap();
        
        $object = $this->getObject();
        $object->getEntityManager()->expects($this->once())->method('persist')->with($entity);
        $object->save($entity);
    }

    public function testDelete()
    {
        $entity = new Sitemap();
        
        $object = $this->getObject();
        $object->getEntityManager()->expects($this->once())->method('remove')->with($entity);
        $object->delete($entity);
    }

    /**
     * @param array $methods
     * @return \PHPUnit_Framework_MockObject_MockObject|SitemapService
     */
    public function getObject(array $methods = array())
    {
        if (count($methods)) {
            $object = $this->getMockBuilder('EnliteSitemap\Service\SitemapService')
                ->disableOriginalConstructor()
                ->setMethods($methods)
                ->getMock();
        } else {
            $object = new SitemapService($this->getServiceManager());
        }
        
        $object->setSitemapRepository($this->getRepository());
        $object->setEntityManager($this->getEntityManager());
        
        return $object;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SitemapRepository
     */
    public function getRepository()
    {
        return $this->getMockBuilder('EnliteSitemap\Repository\SitemapRepository')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EntityManager
     */
    public function getEntityManager()
    {
        return $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ServiceManager
     */
    public function getServiceManager()
    {
        return $this->getMock('Zend\ServiceManager\ServiceManager');
    }


}
