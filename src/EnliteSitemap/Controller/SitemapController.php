<?php

namespace EnliteSitemap\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use EnliteSitemap\Service\SitemapServiceTrait;
use Zend\View\Model\ConsoleModel;

class SitemapController extends AbstractActionController
{

    use SitemapServiceTrait;

    public function generateAction()
    {
        $model = new ConsoleModel();
        $files = $this->getSitemapService()->renderStaticSiteMap();
        $text = 'Generated the site map success.' . PHP_EOL
            . 'New/update files:' . PHP_EOL
            . implode(PHP_EOL, $files) . PHP_EOL;
        $model->setResult($text);

        return $model;
    }

}
