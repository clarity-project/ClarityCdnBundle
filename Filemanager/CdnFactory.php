<?php
namespace Clarity\CdnBundle\Filemanager;

use Symfony\Component\DependencyInjection\Container as ServiceContainer;
use Clarity\CdnBundle\Filemanager\Common\CdnInterface;
use Clarity\CdnBundle\Filemanager\Common\ObjectInterface;

/**
 * CdnFactory class
 * 
 * @author nikita prokurat <nickpro@tut.by>
 */
class CdnFactory
{
    protected $config;   
    protected $schema; 
    protected $storage;
    protected $cdn;
    
    /**
     * Constructor
     * 
     * @param Container $container
     * @throws InvalidArgumentException when configurations for cdn were not set
     */
    public function __construct(ServiceContainer $container) 
    {   
        if (!$container->hasParameter('clarity_cdn')) {
            throw new \InvalidArgumentException(sprintf("Cdn options were not set"));
        }
        
        $this->config = $container->getParameter('clarity_cdn');
    }
    
    /**
     * Returns uri schema path
     * 
     * @param ObjectInterface $object
     * @return string
     */ 
    public function composeUriString(ObjectInterface $object)
    {
        return "{$this->storage}://{$object->getContainer()}/{$object->getFileName()}";
    }    
    
    /**
     * Parses uri schema string
     * 
     * @param string $uri
     * @return array
     * @throws InvalidArgumentException when uri schema string is invalid
     */
    public function parseUriString($uri)
    {
        $params = preg_split('#://#', $uri);
        if (!isset($params[0]) || !isset($params[1])) {
            throw new \InvalidArgumentException("Invalid uri string given");
        }
        
        return array(
            'schema' => $params[0],
            'path' => $params[1]
        );
    }       
    
    /**
     * Returns cdn
     * 
     * @param string $cdn
     * @return CdnInterface
     * @throws InvalidArgumentException when needed cdn wasn't set in configurations
     * @throws InvalidArgumentException when needed schema wasn't set in configurations
     */
    public function getCdn($cdn = null)
    {
        if (!$this->cdn && !$cdn) {
            $this->cdn = $this->getDefaultCdn();
        } elseif ($cdn) {
            
            if (!isset($this->config['storages'][$cdn])) {
                throw new \InvalidArgumentException(
                    sprintf('Cdn %s was not found in configurations', $cdn)
                );
            }
            
            if (!isset($this->config['schemas'][$this->config['storages'][$cdn]['schema']])) {
                throw new \InvalidArgumentException(
                    sprintf('Schema %s was not found in configurations', $this->config['storages'][$cdn]['schema'])
                );
            }
            
            $cdnClass = $this->config['schemas'][$this->config['storages'][$cdn]['schema']];
            $this->storage = $cdn;
            $this->cdn = new $cdnClass($this->config['storages'][$cdn]);
        }
        
        return $this->cdn;
    }
    
    /**
     * Returns default cdn
     * 
     * @return string
     * @throws InvalidArgumentException when default cdn wasn't set|found in configs
     */
    protected function getDefaultCdn()
    {     
        if (!isset($this->config['default_storage']) || !isset($this->config['storages'][$this->config['default_storage']])) {
            throw new \InvalidArgumentException(sprintf('Configuration for default cdn %s were not set', $this->config['default']));
        }
        
        return $this->getCdn($this->config['default_storage']);
    }
    
}