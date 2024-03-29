<?php

namespace FondOfSpryker\Client\Contentful;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class ContentfulDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const KV_STORAGE = 'KV_STORAGE';

    /**
     * @var string
     */
    public const CLIENT_SEARCH = 'CLIENT_SEARCH';

    /**
     * @var string
     */
    public const CONTENTFUL_SEARCH_QUERY_PLUGIN = 'CONTENTFUL_SEARCH_QUERY_PLUGIN';

    /**
     * @var string
     */
    public const CONTENTFUL_SEARCH_QUERY_EXPANDER_PLUGINS = 'CONTENTFUL_SEARCH_QUERY_EXPANDER_PLUGINS';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->addStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addStorageClient(Container $container): Container
    {
        $container[static::KV_STORAGE] = function (Container $container) {
            return $container->getLocator()->storage()->client();
        };

        return $container;
    }
}
