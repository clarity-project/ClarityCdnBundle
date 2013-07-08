<?php

namespace Clarity\CdnBundle\Filemanager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Clarity\CdnBundle\Cdn\CdnRegistry;
use Clarity\CdnBundle\Cdn\Common\ObjectInterface;

/**
 * 
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
     * @return ObjectInterface
     */
    public function get($uri, $dimension = null)
    {
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
     * @param string $dimension
     * @param string $cdnContainer
     * @param string $cdn
     * @return boolean|ObjectInterface
     */
    public function upload(UploadedFile $file, $dimension = null, $cdnContainer = null, $cdn = null)
    {
        $this->cdn = $this->factory->getCdn($cdn);
        $object = $this->cdn->container($cdnContainer)->save($file, $dimension);
        
        if (!$object instanceof ObjectInterface) {
            return false;
        }

        $object->setUri($this->factory->composeUriString($object));

        return $object;
    }   
}