<?php

namespace ICS\DashboardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treebuilder = new TreeBuilder('dashboard');

        $treebuilder->getRootNode()
        ->children()
            ->arrayNode('dashboards')
                ->useAttributeAsKey('name')
                ->arrayPrototype()
                    ->children()
                        ->enumNode('nbColumns')
                            ->values([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])
                            ->defaultValue(6)
                        ->end()
                        ->arrayNode('widgets')
                            ->useAttributeAsKey('name')
                            ->arrayPrototype()
                                ->children()
                                    ->scalarNode('entity')->defaultValue('')->end()
                                    ->scalarNode('group')->defaultValue('Public')->end()
                                    ->scalarNode('libelle')->defaultValue('New Widget')->end()
                                    ->scalarNode('icon')->defaultValue('fa fa-cog')->end()
                                    ->arrayNode('roles')
                                        ->scalarPrototype()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end()
        ;

        return $treebuilder;
    }
}
