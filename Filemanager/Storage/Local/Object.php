<?php
namespace Clarity\CdnBundle\Filemanager\Storage\Local;

use Clarity\CdnBundle\Filemanager\Common\ObjectInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Object implements ObjectInterface
{
    private $_uri;
    private $_path; 
    private $_url;    
    private $_container;   
    private $_fileName; 
    
    /**
     * Constructor
     * 
     * @param string $url
     * @param string $path
     * @param string $container
     * @param string $fileName
     */
    public function __construct($url, $path, $container = null, $fileName = null) 
    {
        $this->_url = $url;
        $this->_path = $path;
        $this->_container = $container;
        $this->_fileName = $fileName;
    }
    
    /**
     * Returns file's absolute url
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }
    
    /**
     * Returns file's absolute path
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->_path;
    }
    
    /**
     * Returns file's uri schema string
     * 
     * @return string
     */
    public function getUri()
    {
        return $this->_uri;
    }
    
    /**
     * Sets file's uri schema string
     * 
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->_uri = $uri;
    }
    
    /**
     * Returns file's container
     * 
     * @return string
     */
    public function getContainer()
    {
        return $this->_container;
    }
    
    /**
     * Returns filename
     * 
     * @return string
     */
    public function getFileName()
    {
        return $this->_fileName;
    }
    
    public function __toString()
    {
        return $this->getUrl();
    }    
    
}