<?php
namespace FondOfSpryker\Zed\Contentful;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @author mnoerenberg
 */
class ContentfulDependencyProvider extends AbstractBundleDependencyProvider
{
    public const STORAGE_CLIENT = 'STORAGE_CLIENT';
    public const LOCALE_FACADE = 'LOCALE_FACADE';
    public const RENDERER = 'TWIG';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        //storage client
        $container[static::STORAGE_CLIENT] = function (Container $container) {
            return $container->getLocator()->storage()->client();
        };

        // locale facade
        $container[static::LOCALE_FACADE] = function (Container $container) {
            return $container->getLocator()->locale()->facade();
        };

        return $container;
    }
}
