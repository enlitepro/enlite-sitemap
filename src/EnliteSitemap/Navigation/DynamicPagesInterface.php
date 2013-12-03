<?php
/**
 * The interface for a service what containt dynamic pages
 *
 * @category   Interface
 * @package    Navigation
 * @author     Vladimir Struc <Sysaninster@gmail.com>
 * @license    LICENSE.txt
 * @date       03.12.13
 */

namespace EnliteSitemap\Navigation;


use Traversable;
use Zend\Navigation\Page\AbstractPage;

interface DynamicPagesInterface {

    /**
     * Get pages
     *
     * @return AbstractPage[]|array|Traversable[]
     */
    public function getDynamicPages();

} 