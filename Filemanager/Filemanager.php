<?php

namespace Clarity\CdnBundle\Filemanager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Clarity\CdnBundle\Cdn\CdnRegistry;
use Clarity\CdnBundle\Cdn\Common\ObjectInterface;

/**
 * @author nikita prokurat <nickpro@tut.by>
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class Filemanager
{
    /**
     * 
     * @var CdnRegistry
     */
    protected $registry;
    
    /**
     * 
     * @param CdnRegistry $registry
     */
    public function __construct(CdnRegistry $registry)
    {
        $this->registry = $registry;
    }
    
    /**
     * 
     * @param string $uri
     * @param string $dimension
     * @return ObjectInterface
     */
    public function get($uri, $dimension = null)
    {
        if (null !== $dimension) {
            $uri = $this->addDimensionToName($uri, $dimension);
        }

        return $this->registry->get($uri);
    }
    
    /**
     * @param string $uri
     * @return boolean
     */
    public function remove($uri)
    {
        return $this->get($uri)->remove();
    }
    
    /**
     * Uploads file by configured path
     * 
     * @param UploadedFile $file
     * @param string $container
     * @param string $cdn
     * @param string $dimension
     * @param string $name
     * @return ObjectInterface
     */
    public function upload(UploadedFile $file, $container, $cdn = null, $dimension = null, $name = null)
    {
        $name = (null === $name) ? $file->getClientOriginalName() : $name;
        
        if (null !== $dimension) {
            $name = $this->addDimensionToName($name, $dimension);
        }

        $object = $this->registry->getCdn($cdn)->container($container)->touch($file, $name);
        
        return $object;
    }

    /**
     * 
     * @param string $name
     * @param string $dimension
     * @return string
     */
    public function addDimensionToName($name, $dimension)
    {
        $extension = substr($name, strrpos($name, '.'));

        return str_replace($extension, "@{$dimension}{$extension}", $name);
    }
}
