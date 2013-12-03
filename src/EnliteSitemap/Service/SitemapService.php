<?php

namespace EnliteSitemap\Service;

use EnliteSitemap\Option\CommonOptionsTrait;
use EnliteSitemap\Exception\RuntimeException;
use EnliteSitemap\Navigation\Container;
use EnliteSitemap\Navigation\ContainerIndexInterface;
use EnliteSitemap\Option\URLOptionsTrait;
use EnliteSitemap\View\Helper\Navigation\SitemapIndex;
use Zend\Navigation\AbstractContainer;
use Zend\Navigation\Page\Mvc;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\Navigation;
use Zend\View\Helper\ServerUrl;
use Zend\View\HelperPluginManager;

class SitemapService implements ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait, CommonOptionsTrait, URLOptionsTrait;

    const DEFAULT_CONTAINER = 'EnliteSitemapNavigation';
    const DEFAULT_INDEX_CONTAINER = 'EnliteSitemapIndexNavigation';

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param string $container
     * @return Navigation\Sitemap
     */
    public function getSiteMapHelper($container = self::DEFAULT_CONTAINER)
    {
        /** @var Navigation $navigation */
        $navigation = $this->getServiceLocator()->get('ViewHelperManager')->get('Navigation');
        $navigation->setContainer($container);

        /** @var Navigation\Sitemap $siteMapHelper */
        $siteMapHelper = $navigation->sitemap();
        return $siteMapHelper;
    }

    /**
     * @param string $container
     * @return SitemapIndex|Navigation\HelperInterface
     */
    public function getSiteMapIndexHelper($container = self::DEFAULT_INDEX_CONTAINER)
    {
        /** @var Navigation $navigation */
        $navigation = $this->getServiceLocator()->get('ViewHelperManager')->get('Navigation');
        $navigation->setContainer($container);

        if (!$siteMapIndexHelper = $navigation->findHelper('sitemapIndex', false)) {
            $siteMapIndexHelper = new SitemapIndex();
            $siteMapIndexHelper->setContainer($navigation->getContainer());
            $siteMapIndexHelper->setView($this->getSiteMapHelper()->getView());
        }
        return $siteMapIndexHelper;
    }

    /**
     * Set a valid host, port, scheme to the server url helper
     */
    public function initServerUrlHelper()
    {
        /** @var HelperPluginManager $manager */
        $manager = $this->getServiceLocator()->get('ViewHelperManager');
        /** @var ServerUrl $helper */
        $helper = $manager->get('serverUrl');
        $options = $this->getURLOptions();

        // configure
        $helper->setPort($options->getPort());
        $helper->setScheme($options->getScheme());
        $helper->setHost($options->getHost());
    }

    /**
     * Render static a site map
     *
     * @param string $container
     * @param string $containerIndex
     * @return array
     */
    public function renderStaticSiteMap($container = self::DEFAULT_CONTAINER, $containerIndex = self::DEFAULT_INDEX_CONTAINER)
    {
        $this->initServerUrlHelper();
        $helper = $this->getSiteMapHelper($container);
        $objectContainer = $helper->getContainer();
        $files = [];
        if (!$objectContainer instanceof Container || $objectContainer->countFiles() < 2) {
            if ($objectContainer instanceof Container) {
                $objectContainer->initCurrentFile();
            }
            $files[] = $this->renderSiteMap($helper, $this->getIndexFileName());
        } else {
            $names = [];
            for ($num=0, $count=$objectContainer->countFiles(); $num<$count; $num++) {
                $objectContainer->setCurrentFile($num);
                $name = sprintf($this->getNonIndexFileName(), $num+1);
                $names[] = $name;
                $files[] = $this->renderSiteMap(
                    $helper, $name
                );
            }

            $helperSitemapIndex = $this->getSiteMapIndexHelper($containerIndex);
            $this->prepareContainerIndex($helperSitemapIndex->getContainer(), $names);
            $files[] = $this->renderSiteMap($helperSitemapIndex, $this->getIndexFileName());
        }

        return $files;
    }

    /**
     * Prepare index container
     *
     * @param ContainerIndexInterface $container
     * @param array $names
     * @throws \EnliteSitemap\Exception\RuntimeException
     */
    public function prepareContainerIndex(ContainerIndexInterface $container, array $names)
    {
        if (!$container instanceof ContainerIndexInterface) {
            throw new RuntimeException('$objectContainerIndex must instance of ContainerIndexInterface');
        }
        $container->setNamesSitemaps($names);
        $container->setPublicPath($this->getPath());
        $container->generationPages();
    }

    /**
     * Get path for files
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getCommonOptions()->getPublicPath();
    }

    /**
     * @return string
     */
    public function getIndexFileName()
    {
        return $this->getCommonOptions()->getIndexFile();
    }

    /**
     * @return string
     */
    public function getNonIndexFileName()
    {
        return $this->getCommonOptions()->getNonIndexFile();
    }

    /**
     * Render a site map file
     *
     * @param Navigation\Sitemap $helper
     * @param string $nameFile
     * @return string
     */
    public function renderSiteMap(Navigation\Sitemap $helper, $nameFile)
    {
        $data = $helper->render();
        $path = $this->getPath() . '/' . $nameFile;
        file_put_contents($path, $data);

        return $path;
    }

    /**
     * Factory a site map page
     *
     * @return Mvc
     */
    public function factoryMVCPage()
    {
        $application = $this->getServiceLocator()->get('Application');
        $routeMatch  = $application->getMvcEvent()->getRouteMatch();
        $router      = $this->getServiceLocator()->get('HttpRouter');

        $page = new Mvc();
        $page->setRouteMatch($routeMatch);
        $page->setRouter($router);
        return $page;
    }

}
