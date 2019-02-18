<?php

namespace FondOfSpryker\Client\Contentful;

use FondOfSpryker\Client\Contentful\Plugin\Elasticsearch\Query\ContentfulSearchQueryPlugin;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class ContentfulDependencyProvider extends AbstractDependencyProvider
{
    public const KV_STORAGE = 'KV_STORAGE';

    public const CLIENT_SEARCH = 'CLIENT_SEARCH';

    public const CONTENTFUL_SEARCH_QUERY_PLUGIN = 'CONTENTFUL_SEARCH_QUERY_PLUGIN';

    public const CONTENTFUL_SEARCH_QUERY_EXPANDER_PLUGINS = 'CONTENTFUL_SEARCH_QUERY_EXPANDER_PLUGINS';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->provideStorageClient($container);
        $container = $this->addContentfulSearchQueryPlugin();
        $container = $this->addContentfulSearchQueryExpanderPlugins();

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function provideStorageClient(Container $container): Container
    {
        $container[static::KV_STORAGE] = function (Container $container) {
            return $container->getLocator()->storage()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addContentfulSearchQueryPlugin(Container $container): Container
    {
        $container[static::CONTENTFUL_SEARCH_QUERY_PLUGIN] = function (Container $container) {
            return $this->createContentfulSearchQueryPlugin();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Client\Contentful\Plugin\Elasticsearch\Query\ContentfulSearchQueryPlugin
     */
    protected function createContentfulSearchQueryPlugin(): ContentfulSearchQueryPlugin
    {
        return new ContentfulSearchQueryPlugin();
    }

    /**
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addContentfulSearchQueryExpanderPlugins(): Container
    {
        $container[static::CONTENTFUL_SEARCH_QUERY_EXPANDER_PLUGINS] = function (Container $container) {
            return $this->createContentfulSearchQueryExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return array
     */
    protected function createContentfulSearchQueryExpanderPlugins(): array
    {
        return [];
    }

    protected function addSearchClient(Container $container): Container
    {
        $container[static::CLIENT_SEARCH] = function (Container $container) {
            return $container->getLocator()->search()->client()
        };

        return $container;
    }
}
