<?php

namespace Clarity\CdnBundle\Cdn\Common;


/**
 * @author nikita prokurat <nickpro@tut.by>
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
interface ObjectInterface
{
    /**
     * @return string
     */
    public function getSchemaPath();

    /**
     * @return string
     */
    public function getWebPath();

    /**
     * @return string
     */
    public function getFullPath();

    /**
     * @return string
     */
    public function getRelativePath();

    /**
     * @return string
     */
    public function getContainer();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getExtension();
    
    /**
     * @return boolean 
     */
    public function remove();
}
