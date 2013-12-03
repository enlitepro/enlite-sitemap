<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 02.12.13
 * Time: 16:47
 */

namespace EnliteSitemap\Navigation;


use EnliteSitemap\CommonOptions;
use EnliteSitemap\Exception\RuntimeException;
use Zend\Navigation\Page\Uri;
use Zend\Navigation\Service\AbstractNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContainerFactory extends AbstractNavigationFactory
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Container
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var CommonOptions $commonOptions */
        $commonOptions = $serviceLocator->get('EnliteSitemapCommonOptions');
        $pages = $this->getPages($serviceLocator);

        $container = new Container();
        $container->setPagesPerFile($commonOptions->getLimitUrlInFile());
        $container->addPagesToFile($pages);
        $this->insertDynamicPages($container, $serviceLocator);

        return $container;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param array|\Zend\Config\Config $pages
     * @throws \Zend\Navigation\Exception\InvalidArgumentException
     */
    protected function preparePages(ServiceLocatorInterface $serviceLocator, $pages)
    {
        $application = $serviceLocator->get('Application');
        $routeMatch  = $application->getMvcEvent()->getRouteMatch();
        $router      = $serviceLocator->get('HttpRouter');

        return $this->injectComponents($pages, $routeMatch, $router);
    }

    protected function insertDynamicPages(Container $container, ServiceLocatorInterface $serviceLocator)
    {
        /** @var CommonOptions $commonOptions */
        $commonOptions = $serviceLocator->get('EnliteSitemapCommonOptions');
        $services = $commonOptions->getDynamicPages();
        if (count($services)) {
            foreach ($services as $serviceName) {
                $service = $serviceLocator->get($serviceName);
                if (!$service instanceof DynamicPagesInterface) {
                    throw new RuntimeException('A service for get dynamic pages must be implement DynamicPagesInterface');
                }
                $pages = $service->getDynamicPages();
                if (count($pages)) {
                    $container->addPagesToFile($pages);
                }
            }
        }
    }


    /**
     * @return string
     */
    protected function getName()
    {
        return 'sitemap';
    }
}