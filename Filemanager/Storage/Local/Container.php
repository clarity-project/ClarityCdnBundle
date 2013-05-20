<?php
namespace Clarity\CdnBundle\Filemanager\Storage\Local;

use Clarity\CdnBundle\Filemanager\Common\ContainerInterface;
use Clarity\CdnBundle\Filemanager\Storage\Local\Object;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Container class
 * 
 * @author nikita prokurat <nickpro@tut.by>
 */
class Container implements ContainerInterface
{   
    private $container;
    private $config;   
    private $fullPath;   
    private $uploadPath;   
    private $uploadUrl;   
    private $fileName;    
    private $originalFileName;    
    private static $delimiter = '@';   
    public static $defaultContainer = 'data';  
    
    /**
     * Constructor
     * 
     * @param string $container
     * @param array $config
     */
    public function __construct($container = null, array $config) 
    {
        $this->config = $config;
        $this->container = $container ? $container : self::$defaultContainer;
        $this->uploadPath = $config['upload_path'];
        $this->uploadUrl = $config['upload_url'];
        $this->fullPath = str_replace("//", "/", $this->uploadPath . "/" . $this->container);
    }
    
    /**
     * Moves file to upload dir and builds absolute path and url
     * 
     * @param UploadedFile $file
     * @param string $dimension
     * @return boolean|Object
     */
    public function save(UploadedFile $file, $dimension = null)
    {   
        $this->fileName = $file->getBasename();
        if ($file->getClientOriginalExtension()) 
        {
            $this->fileName .= '.' . $file->getClientOriginalExtension();
        }
        
        $this->originalFileName = $this->fileName;
        
        if ($dimension) {
            $this->fileName .= self::$delimiter . $dimension;
        }
        
        $file->move($this->fullPath, $this->fileName);
        $this->path = $this->fullPath . '/' . $this->fileName;
        $this->url = $this->uploadUrl . '/' . $this->container . '/' . $this->fileName;
        
        if (!is_file($this->path)) {
            return false;
        }
        
        return new Object($this->url, $this->path, $this->container, $this->originalFileName);
    }
    
    /**
     * Returns file object with absolute path and url
     * 
     * @param string $path
     * @param string $dimension
     * @return boolean|Object
     */
    public function get($path, $dimension = null) 
    {
        if ($dimension) {
            $path .= static::$delimiter . $dimension;
        }
        $this->path = $this->uploadPath . '/' . $path;
        $this->url = $this->uploadUrl . '/' . $path;
        
        if (!is_file($this->path)) {
            return false;
        }
        
        return new Object($this->url, $this->path);
    }
    
    /**
     * Removes file from filesystem
     * 
     * @param string $path
     * @param string $dimension
     * @return boolean
     */
    public function remove($path, $dimension = null)
    {
        if ($dimension) {
            $path .= static::$delimiter . $dimension;
        }
        $file = $this->uploadPath . '/' . $path;
        @unlink($file);
        
        if (is_file($file)) {
            return false;
        }
        return true;
    }
}
