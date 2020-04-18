<?php

namespace Ami\AirbrakeBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('ami_airbrake');
        $rootNode = \method_exists($treeBuilder, "getRootNode")
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root("ami_airbrake"); // BC layer for symfony 4.1 and older

        $rootNode
            ->children()
                ->scalarNode('project_id')
                    ->isRequired()
                ->end()
                ->scalarNode('project_key')
                    ->isRequired()
                ->end()
                ->scalarNode('env')
                    ->defaultNull()
                ->end()
                ->scalarNode('host')
                    ->defaultValue('api.airbrake.io')
                ->end()
                ->arrayNode('ignored_exceptions')
                    ->prototype('scalar')->end()
                    ->defaultValue(['Symfony\Component\HttpKernel\Exception\HttpException'])
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
