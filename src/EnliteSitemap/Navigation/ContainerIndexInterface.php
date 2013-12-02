<?php
/**
 * The container index interface
 *
 * @category   Interface
 * @package    Navigation
 * @author     Vladimir Struc <Sysaninster@gmail.com>
 * @license    LICENSE.txt
 * @date       02.12.13
 */

namespace EnliteSitemap\Navigation;


interface ContainerIndexInterface {

    /**
     * Set names of site map file
     *
     * @param array $names
     * @return void
     */
    public function setNamesSitemaps(array $names);

    /**
     * Set public path to sitemap
     *
     * @param string $path
     * @return mixed
     */
    public function setPublicPath($path);

    /**
     * Generation pages with sitemap files
     *
     * @return void
     */
    public function generationPages();

} 