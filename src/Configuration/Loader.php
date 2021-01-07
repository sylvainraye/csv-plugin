<?php declare(strict_types=1);

namespace Kiboko\Component\ETL\Flow\CSV\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Loader implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('loader');

        $builder->getRootNode()
            ->children()
                ->scalarNode('file_path')->isRequired()->end()
                ->scalarNode('delimiter')->defaultValue(',')->end()
                ->scalarNode('enclosure')->defaultValue('"')->end()
                ->scalarNode('escape')->defaultValue('\\')->end()
            ->end();

        return $builder;
    }
}
