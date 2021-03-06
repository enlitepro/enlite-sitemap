<?php

namespace EnliteSitemap\Option;

use EnliteSitemap\Navigation\DynamicPages;
use EnliteSitemap\Navigation\DynamicPagesInterface;
use Zend\Stdlib\AbstractOptions;

class CommonOptions extends AbstractOptions
{

    /**
     * The limitUrlInFile
     *
     * @var int If 0 then unlimited
     */
    protected $limitUrlInFile = 50000;

    /**
     * The publicPath
     *
     * @var string
     */
    protected $publicPath = 'public';

    /**
     * The indexFile
     *
     * @var string
     */
    protected $indexFile = 'sitemap.xml';

    /**
     * The nonIndexFile
     *
     * @var string The name send to sprintf with a number of file
     */
    protected $nonIndexFile = 'sitemap%d.xml';

    /**
     * The dynamicPages
     * Contains services for get dynamic pages (from a service locator)
     *
     * @var DynamicPagesInterface[]
     */
    protected $dynamicPages = [];

    /**
     * @param int $limitUrlInFile
     */
    public function setLimitUrlInFile($limitUrlInFile)
    {
        $this->limitUrlInFile = $limitUrlInFile;
    }

    /**
     * @return int
     */
    public function getLimitUrlInFile()
    {
        return $this->limitUrlInFile;
    }

    /**
     * @param string $publicPath
     */
    public function setPublicPath($publicPath)
    {
        $this->publicPath = $publicPath;
    }

    /**
     * @return string
     */
    public function getPublicPath()
    {
        return $this->publicPath;
    }

    /**
     * @param string $indexFile
     */
    public function setIndexFile($indexFile)
    {
        $this->indexFile = $indexFile;
    }

    /**
     * @return string
     */
    public function getIndexFile()
    {
        return $this->indexFile;
    }

    /**
     * @param string $nonIndexFile
     */
    public function setNonIndexFile($nonIndexFile)
    {
        $this->nonIndexFile = $nonIndexFile;
    }

    /**
     * @return string
     */
    public function getNonIndexFile()
    {
        return $this->nonIndexFile;
    }

    /**
     * @param \EnliteSitemap\Navigation\DynamicPages[] $dynamicPages
     */
    public function setDynamicPages($dynamicPages)
    {
        $this->dynamicPages = $dynamicPages;
    }

    /**
     * @return \EnliteSitemap\Navigation\DynamicPages[]
     */
    public function getDynamicPages()
    {
        return $this->dynamicPages;
    }
}
