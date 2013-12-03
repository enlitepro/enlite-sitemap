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

    public function generationAction()
    {
        $model = new ConsoleModel();
        $files = $this->getSitemapService()->renderStaticSiteMap();
        $text = 'Generated success.' . PHP_EOL
            . 'New/update files:' . PHP_EOL . implode(PHP_EOL, $files);
        $model->setResult($text);

        return $model;
    }

}
