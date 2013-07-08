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
     * Constructor
     * 
     * @param array $config
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Returns default or nedded container
     * 
     * @param string $name
     * @return Container
     */
    public function container($name) 
    {
        return new Container($name, $this->path);
    }
}