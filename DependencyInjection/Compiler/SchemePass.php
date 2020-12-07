<?php

namespace Clarity\CdnBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Clarity\CdnBundle\Cdn\Exception\StorageConfigurationException;

/**
 * Add scheme parameters automatically
 * 
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
 */
class SchemePass implements CompilerPassInterface
{
    /**
     * Default schemas of clarityCdnBundle
     * @var array
     */
    protected $defaultSchemas = array(
        'local' => 'Clarity\CdnBundle\Cdn\Storage\Local\Cdn',
    );

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('clarity_cdn');

        $definition = $container->getDefinition('clarity_cdn.registry');

        if (!isset($config['scheme'])) {
            $config['scheme'] = array();
        } else {
            foreach ($config['scheme'] as $schemeName => $scheme) {
                if (!$container->has($scheme) && !class_exists($scheme)) {
                    throw new StorageConfigurationException($schemeName, $scheme);
                }

                if ($container->has($scheme)) {
                    $scheme = new Reference($scheme);
                }

                $definition->addMethodCall('addScheme', array($schemeName, $scheme));
            }
        }

        foreach ($this->defaultSchemas as $schemeName => $scheme) {
            $definition->addMethodCall('addScheme', array($schemeName, $scheme));
        }
    }
}
