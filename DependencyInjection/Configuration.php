<?php
/*
 * (c) webfactory GmbH <info@webfactory.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
                        ->ifNotInArray(array('html5', 'xhtml10', 'rawhtml'))
                        ->thenInvalid('Invalid parsing mode (choose html5, xhtm10 or rawhtml)')
                ->end();

        return $treeBuilder;
    }
}
