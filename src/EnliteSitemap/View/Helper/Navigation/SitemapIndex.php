<?php
/**
 * The sitemap index generator
 *
 * @category   Helper
 * @package    EnliteSitemap
 * @author     Vladimir Struc <Sysaninster@gmail.com>
 * @license    LICENSE.txt
 * @date       02.12.13
 */

namespace EnliteSitemap\View\Helper\Navigation;


use DOMDocument;
use RecursiveIteratorIterator;
use Zend\Navigation\AbstractContainer;
use Zend\Stdlib\ErrorHandler;
use Zend\View\Exception;
use Zend\View\Helper\Navigation\Sitemap;

class SitemapIndex extends Sitemap
{

    /**
     * Returns a DOMDocument containing the Sitemap index XML for the given container
     *
     * @param  AbstractContainer                 $container  [optional] container to get
     *                                               breadcrumbs from, defaults
     *                                               to what is registered in the
     *                                               helper
     * @return DOMDocument                           DOM representation of the
     *                                               container
     * @throws Exception\RuntimeException            if schema validation is on
     *                                               and the sitemap is invalid
     *                                               according to the sitemap
     *                                               schema, or if sitemap
     *                                               validators are used and the
     *                                               loc element fails validation
     */
    public function getDomSitemap(AbstractContainer $container = null)
    {
        // Reset the urls
        $this->urls = array();

        if (null === $container) {
            $container = $this->getContainer();
        }

        // check if we should validate using our own validators
        if ($this->getUseSitemapValidators()) {
            // create validators
            $locValidator        = new \Zend\Validator\Sitemap\Loc();
            $lastmodValidator    = new \Zend\Validator\Sitemap\Lastmod();
        }

        // create document
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = $this->getFormatOutput();

        // ...and urlset (root) element
        $sitemapIndex = $dom->createElementNS(self::SITEMAP_NS, 'sitemapindex');
        $dom->appendChild($sitemapIndex);

        // create iterator
        $iterator = new RecursiveIteratorIterator($container,
            RecursiveIteratorIterator::SELF_FIRST);

        $maxDepth = $this->getMaxDepth();
        if (is_int($maxDepth)) {
            $iterator->setMaxDepth($maxDepth);
        }
        $minDepth = $this->getMinDepth();
        if (!is_int($minDepth) || $minDepth < 0) {
            $minDepth = 0;
        }

        // iterate container
        foreach ($iterator as $page) {
            if ($iterator->getDepth() < $minDepth || !$this->accept($page)) {
                // page should not be included
                continue;
            }

            // get absolute url from page
            if (!$url = $this->url($page)) {
                // skip page if it has no url (rare case)
                // or already is in the sitemap
                continue;
            }

            // create url node for this page
            $sitemapNode = $dom->createElementNS(self::SITEMAP_NS, 'sitemap');
            $sitemapIndex->appendChild($sitemapNode);

            if ($this->getUseSitemapValidators()
                && !$locValidator->isValid($url)
            ) {
                throw new Exception\RuntimeException(sprintf(
                    'Encountered an invalid URL for Sitemap XML: "%s"',
                    $url
                ));
            }

            // put url in 'loc' element
            $sitemapNode->appendChild($dom->createElementNS(self::SITEMAP_NS,
                'loc', $url));

            // add 'lastmod' element if a valid lastmod is set in page
            if (isset($page->lastmod)) {
                $lastmod = strtotime((string) $page->lastmod);

                // prevent 1970-01-01...
                if ($lastmod !== false) {
                    $lastmod = date('c', $lastmod);
                }

                if (!$this->getUseSitemapValidators() ||
                    $lastmodValidator->isValid($lastmod)) {
                    $sitemapNode->appendChild(
                        $dom->createElementNS(self::SITEMAP_NS, 'lastmod',
                            $lastmod)
                    );
                }
            }
        }

        // validate using schema if specified
        if ($this->getUseSchemaValidation()) {
            ErrorHandler::start();
            $test  = $dom->schemaValidate(self::SITEMAP_XSD);
            $error = ErrorHandler::stop();
            if (!$test) {
                throw new Exception\RuntimeException(sprintf(
                    'Sitemap is invalid according to XML Schema at "%s"',
                    self::SITEMAP_XSD
                ), 0, $error);
            }
        }

        return $dom;
    }

} 