<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 02.12.13
 * Time: 16:47
 */

namespace EnliteSitemap\Navigation;


use EnliteSitemap\CommonOptions;
use Zend\Navigation\Page\Uri;
use Zend\Navigation\Service\AbstractNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContainerFactory extends AbstractNavigationFactory{

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

        return $container;
    }


    /**
     * @return string
     */
    protected function getName()
    {
        return 'sitemap';
    }
}