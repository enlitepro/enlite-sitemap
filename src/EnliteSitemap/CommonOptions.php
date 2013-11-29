<?php

namespace EnliteSitemap;

use Zend\Stdlib\AbstractOptions;

class CommonOptions extends AbstractOptions
{

    /**
     * The limitUrlInFile
     *
     * @var int If 0 then unlimited
     */
    protected $limitUrlInFile = 0;

    /**
     * The publicPath
     *
     * @var string
     */
    protected $publicPath = 'public';

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

}
