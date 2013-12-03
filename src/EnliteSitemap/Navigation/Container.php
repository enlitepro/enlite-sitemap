<?php
/**
 * The container for use with sitemap
 *
 * @category   Navigation
 * @package    EnliteSitemap
 * @author     Vladimir Struc <Sysaninster@gmail.com>
 * @license    LICENSE.txt
 * @date       02.12.13
 */

namespace EnliteSitemap\Navigation;


use Traversable;
use Zend\Navigation\Exception;
use Zend\Navigation\Navigation;
use Zend\Navigation\Page;

class Container extends Navigation
{

    /**
     * The pagesPerFile
     *
     * @var int If 0 then unlimited
     */
    protected $pagesPerFile = 0;

    /**
     * The files
     *
     * @var array
     */
    protected $files = [];

    /**
     * The currentFile
     *
     * @var int
     */
    protected $currentFile = 0;

    /**
     * @param array $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param int $currentFile
     * @param bool $init
     */
    public function setCurrentFile($currentFile, $init = true)
    {
        $this->currentFile = $currentFile;
        if ($init) {
            $this->initCurrentFile();
        }
    }

    /**
     * @return int
     */
    public function getCurrentFile()
    {
        return $this->currentFile;
    }

    /**
     * @param int $pagesPerFile
     */
    public function setPagesPerFile($pagesPerFile)
    {
        $this->pagesPerFile = $pagesPerFile;
    }

    /**
     * @return int
     */
    public function getPagesPerFile()
    {
        return $this->pagesPerFile;
    }

    /**
     * Add a page at a current file
     *
     * @param $page
     */
    public function addPageAtCurrentFile($page)
    {
        if (!isset($this->files[$this->getCurrentFile()])) {
            $this->files[$this->getCurrentFile()] = [];
        }
        $this->files[$this->getCurrentFile()][] = $page;
    }

    /**
     * Add pages from file to container
     */
    public function initCurrentFile()
    {
        $this->removePages();
        if (!isset($this->files[$this->getCurrentFile()])) {
            return;
        }

        $this->addPages($this->files[$this->getCurrentFile()]);
    }

    /**
     * A count of pages at current file
     *
     * @return int
     */
    public function countPagesAtCurrentFile()
    {
        if (!isset($this->files[$this->getCurrentFile()])) {
            return 0;
        }
        return count($this->files[$this->getCurrentFile()]);
    }

    /**
     * @return int
     */
    public function countFiles()
    {
        return count($this->getFiles());
    }

    /**
     * Add pages to file
     *
     * @param array $pages
     * @return $this
     */
    public function addPagesToFile(array $pages)
    {

        if (count($pages)) {
            foreach ($pages as $page) {
                $this->addPageToFile($page);
            }
        }

        return $this;
    }

    /**
     * Add page to file
     *
     * @param $page
     * @return $this
     */
    public function addPageToFile($page)
    {
        if ($this->getCurrentFile() == 0 || $this->countPagesAtCurrentFile() < $this->getPagesPerFile()) {
            $this->addPageAtCurrentFile($page);
        } else {
            $this->setCurrentFile(
                $this->getCurrentFile()+1, false
            );
            $this->addPageAtCurrentFile($page);
        }

        return $this;
    }


}