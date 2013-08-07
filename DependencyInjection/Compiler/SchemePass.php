<?php

namespace Clarity\CdnBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Add scheme parameters automatically
 * 
 * @author Zmicier Aliakseyeu <z.aliakseyeu@gmail.com>
 */
class SchemePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('clarity_cdn');

        if (!isset($config['scheme'])) {
            $config['scheme'] = array();
        }
        $config['scheme']['local'] = 'Clarity\CdnBundle\Cdn\Storage\Local\Cdn';

        $container->setParameter('clarity_cdn', $config);
    }
}