<?php

namespace EnliteSitemap;

use EnliteSitemap\CommonOptions;
use EnliteSitemap\Exception\RuntimeException;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

trait CommonOptionsTrait
{

    /**
     * @var CommonOptions
     */
    protected $commonOptions = null;

    /**
     * @param CommonOptions $commonOptions
     */
    public function setCommonOptions(CommonOptions $commonOptions)
    {
        $this->commonOptions = $commonOptions;
    }

    /**
     * @return CommonOptions
     * @throws RuntimeException
     */
    public function getCommonOptions()
    {
        if (null === $this->commonOptions) {
            if ($this instanceof ServiceLocatorAwareInterface || method_exists($this, 'getServiceLocator')) {
                $this->commonOptions = $this->getServiceLocator()->get('EnliteSitemapCommonOptions');
            } else {
                if (property_exists($this, 'serviceLocator')
                    && $this->serviceLocator instanceof ServiceLocatorInterface
                ) {
                    $this->commonOptions = $this->serviceLocator->get('EnliteSitemapCommonOptions');
                } else {
                    throw new RuntimeException('Service locator not found');
                }
            }
        }
        return $this->commonOptions;
    }


}
