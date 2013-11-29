<?php

namespace EnliteSitemap\Service;

use EnliteSitemap\CommonOptionsTrait;
use Zend\Navigation\AbstractContainer;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\Navigation;

class SitemapService implements ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait, CommonOptionsTrait;

    const DEFAULT_CONTAINER = 'sitemap';

    /**
     * @param string $container
     * @return Navigation\Sitemap
     */
    public function getSiteMapHelper($container = self::DEFAULT_CONTAINER)
    {
        /** @var Navigation $navigation */
        $navigation = $this->getServiceLocator()->get('ViewManager')->get('Navigation');
        $navigation->setContainer($container);

        /** @var Navigation\Sitemap $siteMapHelper */
        $siteMapHelper = $navigation->sitemap();
        return $siteMapHelper;
    }

    public function explodeContainers(AbstractContainer $commonContainer)
    {
        //TODO: realized
//        if (!$this->getCommonOptions()->getLimitUrlInFile() || $)
    }

    public function renderStaticSiteMap($container = self::DEFAULT_CONTAINER)
    {
        $helper = $this->getSiteMapHelper($container);
        $containers = [];

    }


}
