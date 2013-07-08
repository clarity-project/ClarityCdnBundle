<?php

namespace Clarity\CdnBundle\Cdn\Storage\Local;

use Clarity\CdnBundle\Cdn\Common\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Clarity\CdnBundle\Cdn\Exception;

/**
 * 
 * @author nikita prokurat <nickpro@tut.by>
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class Container implements ContainerInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string http address
     */
    private $http;

    /**
     * 
     * @param string $name
     * @param string $path
     * @param string $uri
     * @param string $http address of the server path
     */
    public function __construct($name, $path, $uri, $http) 
    {
        $this->name = $name;
        if (!is_dir($path.DIRECTORY_SEPARATOR.$name) || !is_writable($path.DIRECTORY_SEPARATOR.$name)) {
            throw new Exception\ContainerAccessException($name, $path);
        }

        $this->path = $path.DIRECTORY_SEPARATOR.$name;
        $this->uri  = "{$uri}/{$name}";
        $this->http  = "{$http}/{$name}";
    }

    /**
     * 
     * @param string $name
     * @return Object
     */
    public function get($name) 
    {
        return new Object($name, $this->path, $this->uri, $this->http);
    }
    
    /**
     * 
     * @param UploadedFile $file
     * @param string $name custom file name
     * @return ObjectInterface
     */
    public function touch(UploadedFile $file, $name = null)
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
