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
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getHttpUri()
    {
        return $this->httpUri;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDimension()
    {
        return null;
    }
}