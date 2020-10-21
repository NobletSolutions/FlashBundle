<?php

namespace NS\FlashBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        /**
         * Instantiating a new TreeBuilder without a constructor arg is deprecated in SF4 and removed in SF5
         */
        if(method_exists(TreeBuilder::class, '__construct'))
        {
            $treeBuilder = new TreeBuilder('ns_flash');
            $rootNode = $treeBuilder->getRootNode();
        }
        /**
         * Included for backward-compatibility with SF3
         */
        else
        {
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('ns_flash');
        }

        $rootNode
            ->children()
                ->scalarNode('template')->defaultValue('@NSFlash/Messages/index.html.twig')->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}
