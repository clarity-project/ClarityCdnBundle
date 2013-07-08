<?php

namespace Clarity\CdnBundle\Cdn\Storage\Local;

use Clarity\CdnBundle\Cdn\Common\CdnInterface;

/**
 * @author nikita prokurat <nickpro@tut.by>
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class Cdn implements CdnInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string http adress
     */
    private $http;

    /**
     * 
     * @param string $path
     * @param string $uri
     * @param string $http http server address
     */
    public function __construct($path, $uri, $http)
    {
        $this->path = $path;
        $this->uri = $uri;
        $this->http = $http;
    }

    /**
     * @param string $name
     * @return Container
     */
    public function container($name) 
    {
        return new Container($name, $this->path, $this->uri, $this->http);
    }
}