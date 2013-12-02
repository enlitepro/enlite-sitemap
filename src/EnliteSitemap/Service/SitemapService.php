<?php

namespace EnliteSitemap\Service;

use EnliteSitemap\CommonOptionsTrait;
use EnliteSitemap\Exception\RuntimeException;
use EnliteSitemap\Navigation\Container;
use EnliteSitemap\Navigation\ContainerIndexInterface;
use EnliteSitemap\View\Helper\Navigation\SitemapIndex;
use Zend\Navigation\AbstractContainer;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\Navigation;

class SitemapService implements ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait, CommonOptionsTrait;

    const DEFAULT_CONTAINER = 'sitemap';
    const DEFAULT_INDEX_CONTAINER = 'sitemapIndex';

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

    /**
     * @param string $container
     * @return SitemapIndex|Navigation\HelperInterface
     */
    public function getSiteMapIndexHelper($container = self::DEFAULT_INDEX_CONTAINER)
    {
        /** @var Navigation $navigation */
        $navigation = $this->getServiceLocator()->get('ViewManager')->get('Navigation');
        $navigation->setContainer($container);

        if (!$siteMapIndexHelper = $navigation->findHelper('sitemapIndex', false)) {
            $siteMapIndexHelper = new SitemapIndex();
            $siteMapIndexHelper->setContainer($navigation->getContainer());
        }
        return $siteMapIndexHelper;
    }

    public function renderStaticSiteMap($container = self::DEFAULT_CONTAINER, $containerIndex = self::DEFAULT_INDEX_CONTAINER)
    {
        $helper = $this->getSiteMapHelper($container);
        $objectContainer = $helper->getContainer();
        if (!$objectContainer instanceof Container || $objectContainer->countFiles() < 2) {
            if ($objectContainer instanceof Container) {
                $objectContainer->initCurrentFile();
            }
            $this->renderSiteMap($helper, $this->getIndexFileName());
        } else {
            $names = [];
            for ($num=0, $count=$objectContainer->countFiles(); $num<$count; $num++) {
                $objectContainer->setCurrentFile($num);
                $name = sprintf($this->getNonIndexFileName(), $num+1);
                $names[] = $name;
                $this->renderSiteMap(
                    $helper, $name
                );
            }

            $helperSitemapIndex = $this->getSiteMapIndexHelper($containerIndex);
            $this->prepareContainerIndex($helperSitemapIndex->getContainer(), $names);
            $this->renderSiteMap($helperSitemapIndex, $this->getIndexFileName());
            // TODO: config, helper, controller
        }

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
     */
    public function renderSiteMap(Navigation\Sitemap $helper, $nameFile)
    {
        $data = $helper->render();
        file_put_contents($this->getPath() . $nameFile, $data);
    }


}
