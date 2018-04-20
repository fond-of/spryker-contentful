<?php
namespace FondOfSpryker\Client\Contentful;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

/**
 * @author mnoerenberg
 */
class ContentfulDependencyProvider extends AbstractDependencyProvider
{
    public const CLIENT_LOCALE = 'client locale';
    public const KV_STORAGE = 'kv storage';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->provideStorageClient($container);
        $container = $this->provideLocaleClient($container);

        return $container;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideStorageClient(Container $container): Container
    {
        $container[static::KV_STORAGE] = function (Container $container) {
            return $container->getLocator()->storage()->client();
        };

        return $container;
    }

    /**
     * @author mnoerenberg
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideLocaleClient(Container $container): Container
    {
        $container[static::CLIENT_LOCALE] = function (Container $container) {
            return $container->getLocator()->locale()->client();
        };

        return $container;
    }
}
