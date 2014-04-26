<?php

namespace Clarity\CdnBundle\Cdn\Storage;

use Clarity\CdnBundle\Cdn\Common\CdnInterface;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
abstract class AbstractCdnStorage implements CdnInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string http adress
     */
    protected $http;

    /**
     * @param string $name
     * @return \Clarity\CdnBundle\Cdn\Common\ContainerInterface
     */
    abstract function container($name);

    /**
     * @param string $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param string $uri
     *
     * @return self
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @param string $http
     *
     * @return self
     */
    public function setHttp($http)
    {
        $this->http = $http;

        return $this;
    }
}
