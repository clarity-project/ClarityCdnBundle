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
     * Returns file object by uri schema
     * 
     * @param string $uri
     * @param string $dimension
     * @return ObjectInterface
     */
    public function get($uri, $dimension = null)
    {
        $params = $this->factory->parseUriString($uri);
        return $this->factory->getCdn($params['schema'])->container()->get($params['path'], $dimension);
    }
    
    /**
     * Removes file by uri schema
     * 
     * @param string $uri
     * @param string $dimension
     * @return boolean
     */
    public function remove($uri, $dimension = null)
    {
        $params = $this->factory->parseUriString($uri);
        return $this->factory->getCdn($params['schema'])->container()->remove($params['path'], $dimension);
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