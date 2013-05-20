<?php
namespace Clarity\CdnBundle\Filemanager\Common;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author nikita prokurat <nickpro@tut.by>
 */
interface ObjectInterface 
{   
    /**
     * Returns file's absolute url
     * 
     * @return string
     */    
    public function getUrl();
    
    /**
     * Returns file's absolute path
     * 
     * @return string
     */    
    public function getPath();
    
    /**
     * Returns file's uri schema string
     * 
     * @return string
     */    
    public function getUri();
    
    /**
     * Sets file's uri schema string
     * 
     * @param string $uri
     */    
    public function setUri($uri);
    
    /**
     * Returns file's container
     * 
     * @return string
     */    
    public function getContainer();
    
    /**
     * Returns filename
     * 
     * @return string
     */    
    public function getFileName();
}
