<?php

namespace Clarity\CdnBundle\Cdn\Storage\Local;

use Clarity\CdnBundle\Cdn\Common\ObjectInterface;
use Clarity\CdnBundle\Cdn\Exception;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
 */
class Object implements ObjectInterface
{
    /**
     * @var string
     */
    private $fullPath;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $schemaPath;

    /**
     * @var string
     */
    private $webPath;

    /**
     * @var string
     */
    private $container;

    /**
     * @var string
     */
    private $extension;

    /**
     * @param string $name
     * @param string $fullPath
     * @param string $schema
     * @param string $webPath
     * @throws \Clarity\CdnBundle\Cdn\Exception\ObjectAccessException
     */
    public function __construct($name, $fullPath, $schema, $webPath)
    {
        $this->name = $name;

        if (!is_file($fullPath . DIRECTORY_SEPARATOR . $name) || !is_readable($fullPath . DIRECTORY_SEPARATOR . $name)) {
            throw new Exception\ObjectAccessException($fullPath . DIRECTORY_SEPARATOR . $name);
        }

        list($scheme, $container) = explode('://', $schema);

        $this->container    = $container . DIRECTORY_SEPARATOR . $name;
        $this->fullPath     = $fullPath . DIRECTORY_SEPARATOR . $name;
        $this->schemaPath   = "{$schema}/{$name}";
        $this->webPath      = "{$webPath}/{$name}";

        /*
         * @var string $basePathDelimiter "../web" string to find relative path
         */
        $basePathDelimiter = '..' . DIRECTORY_SEPARATOR . 'web';
        $this->relativePath = substr(
            $this->fullPath,
            strrpos(
                $this->fullPath,
                $basePathDelimiter
            ) + strlen($basePathDelimiter)
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->webPath;
    }

    /**
     * {@inheritDoc}
     */
    public function getSchemaPath()
    {
        return $this->schemaPath;
    }

    /**
     * {@inheritDoc}
     */
    public function getWebPath()
    {
        return $this->webPath;
    }

    /**
     * {@inheritDoc}
     */
    public function getFullPath()
    {
        return $this->fullPath;
    }

    /**
     * {@inheritDoc}
     */
    public function getRelativePath()
    {
        return $this->relativePath;
    }

    /**
     * {@inheritDoc}
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getExtension()
    {
        if (null === $this->extension) {
            $this->extension = substr($this->name, strrpos($this->name, '.') + 1);
        }

        return $this->extension;
    }

    /**
     * {@inheritDoc}
     */
    public function remove()
    {
        if (unlink($this->fullPath)) {
            return true;
        }

        return false;
    }
}
