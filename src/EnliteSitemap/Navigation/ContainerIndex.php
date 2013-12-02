<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 02.12.13
 * Time: 19:16
 */

namespace EnliteSitemap\Navigation;


use Zend\Navigation\AbstractContainer;
use Zend\Navigation\Page\Uri;

class ContainerIndex extends AbstractContainer implements ContainerIndexInterface
{

    /**
     * The names
     *
     * @var array
     */
    protected $names = [];

    /**
     * The publicPath
     *
     * @var string
     */
    protected $publicPath = '';

    /**
     * Set names of site map file
     *
     * @param array $names
     * @return void
     */
    public function setNamesSitemaps(array $names)
    {
        $this->names = $names;
    }

    /**
     * Set public path to sitemap
     *
     * @param string $path
     * @return mixed
     */
    public function setPublicPath($path)
    {
        $this->publicPath = $path;
    }

    /**
     * @return string
     */
    public function getPublicPath()
    {
        return $this->publicPath;
    }

    /**
     * @return array
     */
    public function getNamesSitemaps()
    {
        return $this->names;
    }

    /**
     * Generation pages with sitemap files
     *
     * @return void
     */
    public function generationPages()
    {
        $names = $this->getNamesSitemaps();
        if (!count($names)) {
            return;
        }
        foreach ($names as $name) {
            $page = $this->factoryPage();
            $page->setTitle($name);
            $page->setUri($this->getPublicPath() . '/' . $name);
            $this->addPage($page);
        }
    }

    /**
     * @return Uri
     */
    public function factoryPage()
    {
        return new Uri();
    }
}