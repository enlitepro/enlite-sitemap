<?php

namespace EnliteSitemap\Option;

use EnliteSitemap\Option\URLOptions;
use EnliteSitemap\Exception\RuntimeException;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

trait URLOptionsTrait
{

    /**
     * @var URLOptions
     */
    protected $uRLOptions = null;

    /**
     * @param URLOptions $uRLOptions
     */
    public function setURLOptions(URLOptions $uRLOptions)
    {
        $this->uRLOptions = $uRLOptions;
    }

    /**
     * @return URLOptions
     * @throws RuntimeException
     */
    public function getURLOptions()
    {
        if (null === $this->uRLOptions) {
            if ($this instanceof ServiceLocatorAwareInterface || method_exists($this, 'getServiceLocator')) {
                $this->uRLOptions = $this->getServiceLocator()->get('EnliteSitemapURLOptions');
            } else {
                if (property_exists($this, 'serviceLocator')
                    && $this->serviceLocator instanceof ServiceLocatorInterface
                ) {
                    $this->uRLOptions = $this->serviceLocator->get('EnliteSitemapURLOptions');
                } else {
                    throw new RuntimeException('Service locator not found');
                }
            }
        }
        return $this->uRLOptions;
    }


}
