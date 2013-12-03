<?php

namespace EnliteSitemap\Option;

use Zend\Stdlib\AbstractOptions;

class URLOptions extends AbstractOptions
{

    /**
     * The host
     *
     * @var string
     */
    protected $host;

    /**
     * The port
     *
     * @var int
     */
    protected $port = 80;

    /**
     * The scheme
     *
     * @var string
     */
    protected $scheme = 'http';

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $scheme
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

}
