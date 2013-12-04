The sitemap module for Zend Framework 2
==============

INSTALL
=======

The recommended way to install is through composer.

```json
{
    "require": {
        "enlitepro/enlite-sitemap": "1.0.*"
    }
}
```

USAGE
=====

Add `EnliteSitemap` to your `config/application.config.php` to enable module.

Static urls you can added to the navigation in section "sitemap".

For dynamic urls you need:

1. Add implementation EnliteSitemap\Navigation\DynamicPagesInterface to any service. This service
must be available for get with help the service locator.
2. Add a key of the service to

```php
[
    'EnliteSitemap' => [
            'common' => [
                'dynamic_pages' => [
                    'YouService'
                ],
            ],
        ],
]
```

Configure
=========

For example config:

```php
[
    'EnliteSitemap' => [
            'common' => [
                // The name site map or site map index (if some files)
                'index_file' => 'sitemap.xml',
                // The name of site map. Use when a site map is some files
                'non_index_file' => 'sitemap%d.xml',
                'public_path' => 'public',
                'limit_url_in_file' => 50000,
                'dynamic_pages' => [],
            ],
            // URL for all links in site map
            'url' => [
                'host' => 'my.site.com',
                'port' => 80,
                'scheme' => 'http',
            ]
        ],
]
```
