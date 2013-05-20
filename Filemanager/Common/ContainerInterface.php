<?php
namespace Clarity\CdnBundle\Filemanager\Common;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author nikita prokurat <nickpro@tut.by>
 */
interface ContainerInterface
{
    /**
     * Moves file to upload dir and builds absolute path and url
     * 
     * @param UploadedFile $file
     * @param string $dimension
     * @return boolean|Object
     */    
    public function save(UploadedFile $file);
    
    /**
     * Returns file object with absolute path and url
     * 
     * @param string $path
     * @param string $dimension
     * @return boolean|Object
     */    
    public function get($path);
    
    /**
     * Removes file from filesystem
     * 
     * @param string $path
     * @param string $dimension
     * @return boolean
     */    
    public function remove($path);
}