<?php
namespace Clarity\CdnBundle\Filemanager\Common;

/**
 * @author nikita prokurat <nickpro@tut.by>
 */
interface CdnInterface
{  
    /**
     * Returns default or nedded container
     * 
     * @param string $name
     * @return Container
     */    
    public function container($name = null);
}