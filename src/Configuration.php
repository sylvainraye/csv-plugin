<?php declare(strict_types=1);

namespace Kiboko\Component\ETL\Flow\CSV;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    private ConfigurationInterface $loggerConfiguration;

    public function __construct(?ConfigurationInterface $loggerConfiguration = null)
    {
        $this->loggerConfiguration = $loggerConfiguration ?? new Configuration\Logger();
    }

    public function getConfigTreeBuilder()
    {
        $extractor = new Configuration\Extractor();
        $loader = new Configuration\Loader();

        $builder = new TreeBuilder('csv');
        $builder->getRootNode()
            ->validate()
                ->ifTrue(function (array $value) {
                    return array_key_exists('extractor', $value) && array_key_exists('loader', $value);
                })
                ->thenInvalid('Your configuration should either contain the "extractor" or the "loader" key, not both.')
            ->end()
            ->children()
                ->append(node: $extractor->getConfigTreeBuilder()->getRootNode())
                ->append(node: $loader->getConfigTreeBuilder()->getRootNode())
                ->append(node: $this->loggerConfiguration->getConfigTreeBuilder()->getRootNode())
            ->end()
        ;

        return $builder;
    }
}
