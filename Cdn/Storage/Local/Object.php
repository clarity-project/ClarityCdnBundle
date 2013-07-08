<?php

namespace Clarity\CdnBundle\Cdn\Storage\Local;

use Clarity\CdnBundle\Cdn\Common\ObjectInterface;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class Object implements ObjectInterface
{
    /**
     * @param string $name
     * @param string $containerPath
     * @param string $containerUri
     */
    public function __construct($name, $containerPath, $containerUri)
    {
        
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