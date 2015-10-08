<?php

namespace Clarity\CdnBundle\Twig\Extension;

use Clarity\CdnBundle\Cdn\Exception;
use Clarity\CdnBundle\Filemanager\Filemanager;

/**
 * Twig extension for easy access to cdn objects from view
 * 
 * @author nikita prokurat <nickpro@tut.by>
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
 */
class CdnExtension extends \Twig_Extension
{
    /**
     * @var \Clarity\CdnBundle\Filemanager\Filemanager
     */
    private $filemanager;

    /**
     * Constructor
     * 
     * @param Clarity\CdnBundle\Filemanager\Filemanager $filemanager
     */
    public function __construct(Filemanager $filemanager)
    {
        $this->filemanager = $filemanager;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'clarity_cdn' => new \Twig_Function_Method($this, 'getImage'),
            'clarity_cdn_safe' => new \Twig_Function_Method($this, 'getImageSafe')
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

    /**
     * Returns cdn object or null if can't find passed uri
     *
     * @param string $uri
     * @param string $dimension
     * @return boolean|Object
     */
    public function getImageSafe($uri, $dimension = null)
    {
        try {
            return $this->filemanager->get($uri, $dimension);
        } catch (Exception\ObjectAccessException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'cdn_extension';
    }
}
