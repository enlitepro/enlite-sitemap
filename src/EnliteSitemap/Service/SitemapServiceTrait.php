<?php

namespace EnliteSitemap\Service;

use EnliteSitemap\Service\SitemapService;
use EnliteSitemap\Exception\RuntimeException;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

trait SitemapServiceTrait
{

    /**
     * @var SitemapService
     */
    protected $sitemapService = null;

    /**
     * @param SitemapService $sitemapService
     */
    public function setSitemapService(SitemapService $sitemapService)
    {
        $this->sitemapService = $sitemapService;
    }

    /**
     * @return SitemapService
     * @throws RuntimeException
     */
    public function getSitemapService()
    {
        if (null === $this->sitemapService) {
            if ($this instanceof ServiceLocatorAwareInterface || method_exists($this, 'getServiceLocator')) {
                $this->sitemapService = $this->getServiceLocator()->get('EnliteSitemapSitemapService');
            } else {
                if (property_exists($this, 'serviceLocator')
                    && $this->serviceLocator instanceof ServiceLocatorInterface
                ) {
                    $this->sitemapService = $this->serviceLocator->get('EnliteSitemapSitemapService');
                } else {
                    throw new RuntimeException('Service locator not found');
                }
            }
        }
        return $this->sitemapService;
    }


}
