<?php
namespace Clarity\CdnBundle\Twig;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Clarity\CdnBundle\Filemanager\Filemanager;

/**
 * Twig extension for easy access to cdn objects from view
 * 
 * @author nikita prokurat <nickpro@tut.by>
 */
class CdnExtension extends \Twig_Extension {
    
    private $filemanager;
    
    /**
     * Constructor
     * 
     * @param Filemanager $filemanager
     */
    public function __construct(Filemanager $filemanager) {
        $this->filemanager = $filemanager;
    }
    
    public function getFunctions() {
        return array(
            'clarity_cdn' => new \Twig_Function_Method($this, 'getImage')
        );
    }
    
    /**
     * Returns cdn object
     * 
     * @param string $uri
     * @param string $dimension
     * @return boolean|Object
     */
    public function getImage($uri, $dimension = null)
    {
        return $this->filemanager->get($uri, $dimension);
    }

    public function getName()
    {
        return 'cdn_extension';
    }
      

}