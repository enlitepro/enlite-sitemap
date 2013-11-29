<?php

namespace EnliteSitemap\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use EnliteSitemap\Service\SitemapServiceTrait;

class SitemapController extends AbstractActionController
{

    use SitemapServiceTrait;




}
