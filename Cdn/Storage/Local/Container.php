<?php

namespace Clarity\CdnBundle\Cdn\Storage\Local;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Clarity\CdnBundle\Cdn\Common\ContainerInterface;
use Clarity\CdnBundle\Cdn\Exception;

/**
 * @author nikita prokurat <nickpro@tut.by>
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
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
    private $fullPath;

    /**
     * @var string
     */
    private $schema;

    /**
     * @var string
     */
    private $webPath;

    /**
     * 
     * @param string $name
     * @param string $fullPath
     * @param string $schemaPrefix
     * @param string $webPath
     * @throws \Clarity\CdnBundle\Cdn\Exception\ContainerAccessException
     */
    public function __construct($name, $fullPath, $schemaPrefix, $webPath)
    {
        $this->name = $name;
        if (!is_dir($fullPath . DIRECTORY_SEPARATOR . $name)) {
            if (!mkdir($fullPath . DIRECTORY_SEPARATOR . $name, 0777, true)) {
                throw new Exception\ContainerAccessException($name, $fullPath);
            }
        }
        
        if (!is_writable($fullPath . DIRECTORY_SEPARATOR . $name)) {
            throw new Exception\ContainerAccessException($name, $fullPath);
        }

        $this->fullPath = $fullPath . DIRECTORY_SEPARATOR . $name;
        $this->schema   = $schemaPrefix . $name;
        $this->webPath  = "{$webPath}/{$name}";
    }

    /**
     * {@inheritDoc}
     */
    public function get($name)
    {
        return new Object($name, $this->fullPath, $this->schema, $this->webPath);
    }

    /**
     * {@inheritDoc}
     */
    public function remove($name)
    {
        return $this->get($name)->remove();
    }

    /**
     * {@inheritDoc}
     */
    public function touch(UploadedFile $file, $name = null)
    {
        $name = (null === $name) ? $file->getClientOriginalName() : $name;
        $file->move($this->fullPath, $name);
        
        return $this->get($name);
    }
}
