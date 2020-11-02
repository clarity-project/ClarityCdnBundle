<?php

namespace Clarity\CdnBundle\Cdn;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
 */
class CdnRegistry implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var array
     */
    private $configuration;

    /**
     * @var array
     */
    private $schemas;

    /**
     * @var array
     */
    private $storages;

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
        $this->storages = array();
        $this->schemas = array();
    }

    /**
     * @param string $uri
     * @return \Clarity\CdnBundle\Cdn\Common\ObjectInterface
     */
    public function get($uri)
    {
        $params = $this->parse($uri);
        $cdn = $this->getCdn($params['scheme']);
        $object = $cdn->container($params['host'])->get($params['path']);

        return $object;
    }

    /**
     * @param string $name
     * @return \Clarity\CdnBundle\Cdn\Common\CdnInterface
     */
    public function getCdn($name = null)
    {
        if (null === $name) {
            return $this->getDefaultCdn();
        }

        if (!$this->hasStorage($name)) {
            $config = $this->getStorageConfiguration($name);

            $storage = $this->createStorage(
                $config['scheme'],
                $config['path'],
                "$name://",
                $config['url']
            );

            $this->addStorage($name, $storage);
        }

        return $this->getStorage($name);
    }

    /**
     * @return Common\CdnInterface
     */
    public function getDefaultCdn()
    {
        $default = $this->configuration['default'];

        return $this->getCdn($default);
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasStorage($name)
    {
        return array_key_exists($name, $this->storages);
    }

    /**
     * @param string $name
     * @param \Clarity\CdnBundle\Cdn\Common\CdnInterface $storage
     * @throws Exception\StorageRedeclareException
     * @return self
     */
    public function addStorage($name, $storage)
    {
        if ($this->hasStorage($name)) {
            throw new Exception\StorageRedeclareException($name);
        }

        $this->storages[$name] = $storage;

        return $this;
    }

    /**
     * @param string $name
     * @throws Exception\StorageRedeclareException
     * @return \Clarity\CdnBundle\Cdn\Common\CdnInterface
     */
    public function getStorage($name)
    {
        if (!$this->hasStorage($name)) {
            throw new Exception\StorageRedeclareException($name);
        }

        return $this->storages[$name];
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasScheme($name)
    {
        return array_key_exists($name, $this->schemas);
    }

    /**
     * @param string $name
     * @throws Exception\ShemeRedeclareException
     * @param string|\Symfony\Component\DependencyInjection\Reference $scheme
     *
     * @return self
     */
    public function addScheme($name, $scheme)
    {
        if ($this->hasScheme($name)) {
            throw new Exception\ShemeRedeclareException($name);
        }

        $this->schemas[$name] = $scheme;

        return $this;
    }

    /**
     * @param string $name
     * @throws Exception\SchemeNotFoundException
     * @return string|\Symfony\Component\DependencyInjection\Reference
     */
    public function getScheme($name)
    {
        if (!$this->hasScheme($name)) {
            throw new Exception\SchemeNotFoundException($name);
        }

        return $this->schemas[$name];
    }

    /**
     * @param string $name
     * @throws Exception\ConfigurationNotFoundException
     * @return array
     */
    private function getStorageConfiguration($name)
    {
        if (!array_key_exists($name, $this->configuration['storage'])) {
            throw new Exception\ConfigurationNotFoundException($name);
        }

        return $this->configuration['storage'][$name];
    }

    /**
     * @param string $name
     * @param string $fullPath
     * @param string $schemaPrefix
     * @param string $webPath
     * @throws Exception\SchemeNotFoundException
     *
     * @return \Clarity\CdnBundle\Cdn\Common\CdnInterface
     */
    private function createStorage($name, $fullPath, $schemaPrefix, $webPath)
    {
        $scheme = $this->getScheme($name);

        if ($scheme instanceof Reference) {
            /** @var \Clarity\CdnBundle\Cdn\Common\CdnInterface $storage */
            $storage = $this->container->get($scheme);
        } else {
            /** @var \Clarity\CdnBundle\Cdn\Common\CdnInterface $storage */
            $storage = new $scheme();
        }

        $storage
            ->setFullPath($fullPath)
            ->setSchemaPrefix($schemaPrefix)
            ->setWebPath($webPath);

        return $storage;
    }

    /**
     * Parsing uri and return array of uri data
     *
     * @param string $uri
     * @throws Exception\InvalidUriException
     * @return array
     */
    private function parse($uri)
    {
        $params = parse_url($uri);

        if (!isset($params['host']) || !isset($params['scheme']) || !isset($params['path'])) {
            throw new Exception\InvalidUriException($uri);
        }

        $params['path'] = substr($params['path'], 1);

        return $params;
    }
}
