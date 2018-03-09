<?php
namespace FondOfSpryker\Zed\Contentful;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @author mnoerenberg
 */
class ContentfulDependencyProvider extends AbstractBundleDependencyProvider {

    public const KV_STORAGE = 'KV_STORE';
    public const RENDERER  = 'twig';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container) {

        //storage client
        $container[static::KV_STORAGE] = function (Container $container) {
            return $container->getLocator()->storage()->client();
        };

        return $container;
    }
}