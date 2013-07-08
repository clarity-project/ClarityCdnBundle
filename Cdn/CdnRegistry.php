<?php

namespace Clarity\CdnBundle\Cdn;

/**
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class CdnRegistry
{
    /**
     * @var array
     */
    private $configuration;

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
    }

    /**
     * @param string $uri
     * @return Common\ObjectInterface
     */
    public function get($uri)
    {
        $params = $this->parse($uri);
        $cdn = $this->getCdn($params['scheme']);
        $object = $cdn->container($params['host'])->get($params['path']);

        return $object;
    }

    /**
     * @param  string $name
     * @return Common\CdnInterface
     */
    public function getCdn($name = null)
    {
        if (null === $name) {
            return $this->getDefaultCdn();
        }

        if (!isset($this->storages[$name])) {
            if (!isset($this->configuration['storage'][$name])) {
                throw new Exception\ConfigurationNotFoundException($name);
            }
            $config = $this->configuration['storage'][$name];
            $scheme = $this->scheme($config['scheme']);
            $this->storages[$name] = new $scheme($config['path'], "$name://", $config['url']);
        }

        return $this->storages[$name];
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
     * Parsing uri and return array of uri data
     * 
     * @param string $uri
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

    /**
     * @param string $name
     * @return string
     * @throws Exception\InvalidSchemeException
     */
    private function scheme($name)
    {
        if (!isset($this->configuration['scheme'][$name])) {
            throw new Exception\InvalidSchemeException($name);
        }

        return $this->configuration['scheme'][$name];
    }
}