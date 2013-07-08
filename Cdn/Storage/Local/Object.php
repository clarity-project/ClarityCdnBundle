<?php

namespace Clarity\CdnBundle\Cdn\Storage\Local;

use Clarity\CdnBundle\Cdn\Common\ObjectInterface;
use Clarity\CdnBundle\Cdn\Exception;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class Object implements ObjectInterface
{
    /**
     * @param string $name
     * @param string $path
     * @param string $uri
     * @param string $http
     */
    public function __construct($name, $path, $uri, $http)
    {
        $this->name = $name;
        if (!is_file($path.DIRECTORY_SEPARATOR.$name) || !is_readable($path.DIRECTORY_SEPARATOR.$name)) {
            throw new Exception\ObjectAccessException($path.DIRECTORY_SEPARATOR.$name);
        }

        $this->path = $path.DIRECTORY_SEPARATOR.$name;
        $this->uri  = "{$uri}/{$name}";
        $this->http  = "{$http}/{$name}";
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->http;
    }

    /**
     * {@inheritDoc}
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpUri()
    {
        return $this->httpUri;
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getDimension()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function remove()
    {
        die(var_dump('asdfasdf'));
        return false;
    }
}