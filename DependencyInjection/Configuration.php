<?php

namespace Webfactory\Bundle\LegacyIntegrationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('webfactory_legacy_integration')
            ->children()
                ->scalarNode('legacyApplicationBootstrapFile')->defaultValue('%project.webdir%/wfD2Engine.php')->end()
                ->scalarNode('parsingMode')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray(array('html5', 'xhtml10'))
                        ->thenInvalid('Invalid parsing mode (choose html5 or xhtm10)')
                ->end();

        return $treeBuilder;
    }
}
