<?php
/**
 * The index container
 *
 * @category   Navigation
 * @package    EnliteSitemap
 * @author     Vladimir Struc <Sysaninster@gmail.com>
 * @license    LICENSE.txt
 * @date       02.12.13
 */

namespace EnliteSitemap\Navigation;


use DateTime;
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
        $changed = new DateTime();
        if (!count($names)) {
            return;
        }
        foreach ($names as $name) {
            $page = $this->factoryPage();
            $page->setTitle($name);
            $page->setUri('/' . $this->getPublicPath() . '/' . $name);
            $page->set('lastmod', $changed->format(DateTime::W3C));
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