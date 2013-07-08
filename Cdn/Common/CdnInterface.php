<?php

namespace Clarity\CdnBundle\Cdn\Common;

/**
 * @author nikita prokurat <nickpro@tut.by>
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
interface CdnInterface
{  
    /**
     * Returns default or nedded container
     * 
     * @param string $name
     * @return ContainerInterface
     */    
    public function container($name);
}