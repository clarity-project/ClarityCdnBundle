<?php

namespace Clarity\CdnBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('clarity_cdn');

        $rootNode
            ->children()
                ->scalarNode('default')
                    ->isRequired(true)
                ->end()
                ->arrayNode('scheme')
                    ->prototype('scalar')
                    ->end()
                ->end()
                ->arrayNode('storage')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('scheme')
                            ->isRequired(true)
                        ->end()
                        ->scalarNode('path')
                            ->isRequired(true)
                        ->end()
                        ->scalarNode('url')
                            ->isRequired(true)
                        ->end()
                    ->end()
            ->end();

        return $treeBuilder;
    }
}
