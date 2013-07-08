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
     * 
     * @param string $path
     * @param string $uri
     */
    public function __construct($path, $uri)
    {
        $this->path = $path;
        $this->uri = $uri;
    }

    /**
     * @param string $name
     * @return Container
     */
    public function container($name) 
    {
        return new Container($name, $this->path, $this->uri);
    }
}